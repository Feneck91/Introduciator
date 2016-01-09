<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2013 @copyright (c) 2014 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/**
	 * @var \phpbb\user Current connected user.
	 */
	private $user;
	
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
	 */
	public function __construct(\phpbb\user $user)
	{
		global $phpbb_container;
		// Get Introduciator class helper
		$this->introduciator_helper = $phpbb_container->get('feneck91.introduciator.helper');

		// Record parameters into this
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.submit_post_end'	 => 'on_submit_post',	// When user post a message, verify the introduce has been done
		);
	}

	public function on_submit_post($data, $mode, $poll, $post_visibility, $subject, $topic_type, $update_message, $update_search_index, $url, $username)
	{
		//$this->introduciator_helper->introduciator_verify_posting($user, $mode, $forum_id, $post_id, $data);
		//$this->user->add_lang_ext('cabot/quickreplytoggle', 'quickreplytoggle');
		print('toto<br/>');
		$toto = 0;
	} 
}
