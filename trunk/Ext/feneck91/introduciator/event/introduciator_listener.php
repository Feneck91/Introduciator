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
	 * See : https://wiki.phpbb.com/Event_List
	 *
	 * @return An array that contains event list with associated callback for each event.
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_page_title'							=> array('on_before_quickreply_displayed', -2),	// Hide quick reply if user is not allowed to post
			'core.posting_modify_template_vars'							=> 'on_displaying_posting_screen',				// Verify if the posting is allowed or not; display message if not
			'core.posting_modify_submit_post_before'					=> 'on_submit_post',							// When user post a message, verify the introduce has been done
			'core.submit_post_end'										=> 'on_submit_post_end',						// Change the url to go to if the user edit it's own unapproved introduction
			'core.viewforum_get_topic_ids_data'							=> 'on_get_topic_ids',							// Allow the user that create own introduction to view it into the list of the topic, changing the SQL request to get approved topic + own introduce
			'core.viewforum_modify_topicrow'							=> 'on_display_unapproved_question_mark',		// Allow displaying '?' into the topic list when the user see its own introduce
			'core.phpbb_content_visibility_is_visible'					=> 'is_topic_visible',							// Allow the user that create own introduction to view it when it open the unapproved topic introduction. Else phpBB say that the topix doesn't exists.
			'core.phpbb_content_visibility_get_visibility_sql_before'	=> 'get_topic_sql_visibility',					// Allow phpBB to retrieve a topic for the user that post it into introduce
			'core.viewtopic_modify_post_row'							=> 'on_view_topic_modify_post_row_unapproved',	// Hide S_POST_UNAPPROVED if the user is into his own introduce (hide approved / unapproved) if has not this right.
			
/* Patch to add to posting.php :
 * Search      : // Not able to reply to unapproved posts/topics
 * Add-Before  :  
// Feneck91 - Patch
$vars = array(
	'post_data',
	'poll',
	'mode',
	'topic_id',
	'forum_id',
	'post_author_name',
);
extract($phpbb_dispatcher->trigger_event('core.posting_modify_databefore_patch', compact($vars)));
*/
			'core.posting_modify_databefore_patch'						=> 'on_user_want_post',							// Let the moderator to post into an unapproved post and user to edit own introduce.
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
	 * If user is not allowed to post, an error message is displayed, else if 
	 * the extension has been configure with force introduce approval, set option
	 * to make this message with moderator approval.
	 *
	 * @param $event The event.
	 */
	public function on_submit_post($event)
	{
		if ($this->introduciator_helper->introduciator_verify_posting($this->user, $event['mode'], $event['forum_id'], $event['post_id'], $event['post_data'], true))
		{	// Posting is allowed
			$introduciator_posting_must_be_approved = $this->introduciator_helper->introduciator_is_posting_must_be_approved($this->user, $event['mode'], $event['data']['forum_id']);
			if ($introduciator_posting_must_be_approved)
			{	// If posting should not be approved, let $data['force_approved_state'] unchanged (in case of another MOD has modified it)
				$data = $event['data'];
				$data['force_visibility'] = ITEM_UNAPPROVED; // Force approval
				$event['data'] = $data;
			}
		}
	}
	

	/**
	 * Verify if the user is editing it's own introduction.
	 *
	 * Called when the user submit a post.
	 * If user is not allowed to post, an error message is displayed, else if 
	 * the extension has been configure with force introduce approval, set option
	 * to make this message with moderator approval.
	 *
	 * @param $event The event.
	 */
	public function on_submit_post_end($event)
	{
		global $phpEx, $phpbb_root_path;
		
		switch ($event['mode'])
		{
			case 'edit_first_post':
			case 'edit_last_post':
			case 'edit':
				if ($this->introduciator_helper->introduciator_is_topic_in_forum_is_unapproved_for_introduction($this->user, $event['data']['forum_id'], $event['data']['topic_id'], false))
				{
					$params = '&amp;t=' . $event['data']['topic_id'];
					$params .= '&amp;p=' . $event['data']['post_id'];
					$add_anchor = '#p' . $event['data']['post_id'];
					$url = "{$phpbb_root_path}viewtopic.$phpEx";
					$event['url'] = append_sid($url, 'f=' . $event['data']['forum_id'] . $params) . $add_anchor;
				}
			break;
			case 'post':
			case 'reply':
			case 'quote':
			case 'edit_topic':
				// Nothing to do here
			break;
		}		
	}
	
	/**
	 * Allow the user that create own introduction to view it into the list of the topic, changing the SQL request to get approved topic + own introduce.
	 *
	 * @param $event The event.
	*/
	public function on_get_topic_ids($event)
	{
		if (!empty($event['sql_approved']))
		{
			$sql_approved = $this->introduciator_helper->introduciator_generate_sql_approved_for_forum($this->user, $event['forum_data']['forum_id'], $event['sql_approved'], 't');
			if ($sql_approved !== $event['sql_approved'])
			{	// Modified by function, should re-inject into sql statement
				$sql_ary = $event['sql_ary'];
				$sql_ary['WHERE'] = str_replace($event['sql_approved'], $sql_approved, $event['sql_ary']['WHERE']);
				$event['sql_ary'] = $sql_ary;
			}
		}
	}
	
	/**
	 * Allow displaying '?' into the topic list when the user see its own introduce.
	 *
	 * Only in the INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT mode.
	 *
	 * @param $event The event.
	*/
	public function on_display_unapproved_question_mark($event)
	{
		if ($this->introduciator_helper->introduciator_is_topic_in_forum_is_unapproved_for_introduction($this->user, $event['row']['forum_id'], $event['row']['topic_id'], false))
		{
			$topic_row = $event['topic_row'];
			$topic_row['REPLIES'] = $topic_row['REPLIES'] + 1; // Else count = -1
			$topic_row['S_TOPIC_UNAPPROVED'] = true;
			$event['topic_row'] = $topic_row;
		}
	}
	
	/**
	 * Allow the user that create own introduction to view it when it open the unapproved topic introduction.
	 *
	 * Else phpBB say that the topic doesn't exists.
	 *
	 * @param $event The event.
	*/
	public function is_topic_visible($event)
	{
		if ($event['mode'] === "topic")
		{
			if ($this->introduciator_helper->introduciator_is_topic_in_forum_is_unapproved_for_introduction($this->user, $event['forum_id'], $event['data']['topic_id'], false))
			{
				$event['is_visible'] = true;
			}
		}
	}
	
	/**
	 * Allow the user that create own introduction to view it into the list of the topic, even the topic is unapproved.
	 *
	 * @param $event The event.
	*/
	public function get_topic_sql_visibility($event)
	{
		$get_visibility_sql_overwrite = null;
		if ($this->introduciator_helper->get_topic_sql_visibility($this->user, $event['forum_id'], $event['where_sql'], $event['mode'], $event['table_alias'], $get_visibility_sql_overwrite))
		{
			$event['get_visibility_sql_overwrite'] = $get_visibility_sql_overwrite;
		}
	}

	/**
	 * Called when the topic is view.
	 * 
	 * But it display Approve / Unapproved field even the user has no right to do this.
	 * If it is a simple user with extension configured as "approvel with edit" we must
	 * hide this fields.
	 * Hide S_POST_UNAPPROVED if the user is into his own introduce.
	 *
	 * @param $event The event.
	*/
	public function on_view_topic_modify_post_row_unapproved($event)
	{
		if ($this->introduciator_helper->introduciator_is_topic_in_forum_is_unapproved_for_introduction($this->user, $event['topic_data']['forum_id'], $event['row']['topic_id'], false))
		{
			$row = $event['post_row'];
			$row['S_POST_UNAPPROVED'] = false;
			$event['post_row'] = $row;
		}
	}

	/**
	 * Called when a user whant to post, before write the message.
	 * 
	 * Only in the INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT mode, allow the moderator to post a reply into an unapproved message.
	 *
	 * @param $event The event.
	*/
	public function on_user_want_post($event)
	{
		if ($this->introduciator_helper->introduciator_let_user_posting_or_editing($this->user, $event['mode'], $event['forum_id'], $event['topic_id'], $event['post_data']))
		{
			$data = $event['post_data'];
			$data['topic_visibility'] = ITEM_APPROVED; // Force approval
			$event['post_data'] = $data;
		}
	}

}
