<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2013 @copyright (c) 2014 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\event;

class introduciator_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
	/**
	 * @var \phpbb\user Current connected user.
	 */
	private $user;
	
	/**
	 * @var \phpbb\template\template Template.
	 */	
	private $template;

	/**
	 * @var \phpbb\template\context Template context.
	 */	
	private $template_context;
	
	/**
	 * Introduciator helper.
	 *
	 * The important code is into this helper.
	 */
	private $introduciator_helper;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user				$user Current connected user.
	 * @param \phpbb\template\template	$template Template.
	 * @param \phpbb\template\context	$template_context Template context.
	 * @param object					$phpbb_container Container object
	 */
	public function __construct(\phpbb\user $user, \phpbb\template\template $template, \phpbb\template\context $template_context, $phpbb_container)
	{
		// Get Introduciator class helper
		$this->introduciator_helper = $phpbb_container->get('feneck91.introduciator.helper');

		// Record parameters into this
		$this->user = $user;
		$this->template = $template;
		$this->template_context = $template_context;
	}

	/**
	 * Called by framework to get event list.
	 *
	 * @return An array that contains event list with associated callback for each event.
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_page_title'          => array('on_before_quickreply_displayed', -2),	// Hide quick reply if user is not allowed to post
			'core.posting_modify_template_vars'			=> 'on_displaying_posting_screen',				// When user post a message, verify the introduce has been done
			'core.posting_modify_submit_post_before'	=> 'on_submit_post',							// When user post a message, verify the introduce has been done
		);
	}
	
	/**
	 * Hide the Quick Reply fields if needed.
	 *
	 * Called before displaying Quick Reply fields, hide all this fields if the user is not allowed to post.
	 * Must change S_QUICK_REPLY and set it to false.
	 *
	 * @param $event The event.
	 * @return true, false or RedirectResponse if redirection is needed.
	 */
	public function on_before_quickreply_displayed($event)
	{	
		$ret = null;
		$root_ref = &$this->template_context->get_root_ref();
		if (!empty($root_ref['S_QUICK_REPLY']))
		{	// Only if Quick Reply is allowed else nothing to do.
			$ret = $this->introduciator_helper->introduciator_verify_posting($this->user, 'reply', $event['forum_id'], 0, null, false);
			if ($ret === false)
			{	// Quick Reply is not allowed, hide it !
				$this->template->assign_var('S_QUICK_REPLY', false);
			}
		}
		
		return $ret;
	}

	/**
	 * Verify if the posting is allowed or not.
	 *
	 * Called when the user want to post, when it's display panel.
	 * Return true, false or RedirectResponse if redirection is needed.
	 *
	 * @param $event The event.
	 * @return Response|RedirectResponse
	 */
	public function on_displaying_posting_screen($event)
	{
		$this->introduciator_helper->introduciator_verify_posting($this->user, $event['mode'], $event['forum_id'], $event['post_id'], $event['post_data'], true);
	} 

	/**
	 * Verify if the posting is allowed or not.
	 *
	 * Called when the user submit a post.
	 *
	 * @param $event The event.
	 */
	public function on_submit_post($event)
	{
		if (!$this->introduciator_helper->introduciator_verify_posting($this->user, $event['mode'], $event['forum_id'], $event['post_id'], $event['post_data'], true))
		{
			$toto = 0;
		}
		/*
		$introduciator_posting_must_be_approved = introduciator_is_posting_must_be_approved($user, $mode, $forum_id);
		if ($introduciator_posting_must_be_approved)
		{	// If posting should not be approved, let $data['force_approved_state'] unchanged (in case of another MOD has modified it)
			$data['force_approved_state'] = false; // Force approval
		}*/
	} 
}
