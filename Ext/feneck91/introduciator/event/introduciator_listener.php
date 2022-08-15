<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) 2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use feneck91\introduciator\helper\introduciator_helper;
use phpbb\user;
use phpbb\template\template;

class introduciator_listener implements EventSubscriberInterface
{
	/**
	 * PhpBB Root path.
	 */
	private $root_path;

	/**
	 * phpBB Extention.
	 */
	private $php_ext;

	/**
	 * @var \phpbb\user Current connected user.
	 */
	private $user;

	/**
	 * @var \phpbb\template\template Template.
	 */
	private $template;

	/**
	 * @var Introduciator helper. The important code is into this helper.
	 */
	private $helper;

	/**
	 * Constructor
	 *
	 * @param string                                                $root_path          phpBB root path.
	 * @param string                                                $php_ext            phpBB Extention.
	 * @param \feneck91\introduciator\helper\introduciator_helper   $helper             Extension helper
	 * @param \phpbb\user                                           $user               Current connected user.
	 * @param \phpbb\template\template                              $template           Template.
	 */
	public function __construct($root_path, $php_ext, introduciator_helper $helper, user $user, template $template)
	{
		// Record parameters into this
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->helper = $helper;
		$this->user = $user;
		$this->template = $template;
	}

	/**
	 * Called by framework to get event list.
	 *
	 * Return an array that contains event list with associated callback for each event.
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'															=> 'load_language_on_setup',					// Load languages files
			'core.viewtopic_modify_quick_reply_template_vars'				=> 'on_before_quickreply_displayed',		// Hide quick reply if user is not allowed to post
			'core.posting_modify_template_vars'									=> 'on_displaying_posting_screen',			// Verify if the posting is allowed or not; display message if not
			'core.posting_modify_submit_post_before'							=> 'on_submit_post_before',					// When user post a message, verify the introduce has been done
			'core.posting_modify_submit_post_after'							=> 'on_submit_post_after',						// When user post a message, if the post is an introduce and must be approved, indicate it to the user
			'core.submit_post_end'													=> 'on_submit_post_end',						// Change the url to go to if the user edit it's own unapproved introduction
			'core.viewforum_get_topic_ids_data'									=> 'on_get_topic_ids',							// Allow the user that create own introduction to view it into the list of the topic, changing the SQL request to get approved topic + own introduce
			'core.viewforum_modify_topicrow'										=> 'on_display_unapproved_question_mark',	// Allow displaying '?' into the topic list when the user see its own introduce
			'core.phpbb_content_visibility_is_visible'						=> 'is_topic_visible',							// Allow the user that create own introduction to view it when it open the unapproved topic introduction. Else phpBB say that the topix doesn't exists.
			'core.phpbb_content_visibility_get_visibility_sql_before'	=> 'get_topic_sql_visibility',				// Allow phpBB to retrieve a topic for the user that post it into introduce
			'core.viewtopic_modify_post_row'										=> 'on_viewtopic_modify_post_row',			// Hide S_POST_UNAPPROVED if the user is into his own introduce (hide approved / unapproved) if has not this right + prepare data to be displayed.
			'core.posting_modify_row_data'										=> 'on_user_want_post',							// Let the moderator to post into an unapproved post and user to edit own introduce. Added in 3.2.8 version of phpBB: https://tracker.phpbb.com/browse/PHPBB3-15946

			//=============================================
			// From here, this is events for template html
			//=============================================
			'core.viewtopic_modify_post_data'									=> 'on_viewtopic_modify_post_data',		// Prepare data to be displayed in viewtopic
			'core.memberlist_prepare_profile_data'								=> 'on_display_profile_data',				// Prepare data to be displayed in several pages
		];
	}

	/**
	 * Load language files during user setup
	 *
	 * @param \phpbb\event\data $event The event object
	 *
	 * @return void
	 * @access public
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'feneck91/introduciator',
			'lang_set' => ['introduciator'],
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Hide the Quick Reply fields if needed.
	 *
	 * Called before displaying Quick Reply fields, hide all this fields if the user is not allowed to post.
	 * Must change S_QUICK_REPLY and set it to false.
	 *
	 * @param $event Event.
	 */
	public function on_before_quickreply_displayed($event)
	{
		if ($event['tpl_ary']['S_QUICK_REPLY'] === true && false === $this->helper->introduciator_verify_posting('reply', $event['forum_id'], 0, null, false)) {	// Quick Reply should be show and is not allowed, hide it !
			$tpl_ary = $event['tpl_ary'];
			$tpl_ary['S_QUICK_REPLY'] = false;
			$event['tpl_ary'] = $tpl_ary;
		}
	}

	/**
	 * Verify if the posting is allowed or not.
	 *
	 * Called when the user want to post, when it's display panel.
	 * Return true, false or RedirectResponse if redirection is needed.
	 *
	 * @param $event Event.
	 */
	public function on_displaying_posting_screen($event)
	{
		$this->helper->introduciator_verify_posting($event['mode'], $event['forum_id'], $event['post_id'], $event['post_data'], true);
	}

	/**
	 * Verify if the posting is allowed or not.
	 *
	 * Called when the user submit a post.
	 * If user is not allowed to post, an error message is displayed, else if
	 * the extension has been configure with force introduce approval, set option
	 * to make this message with moderator approval.
	 *
	 * @param $event Event.
	 */
	public function on_submit_post_before($event)
	{
		if ($this->helper->introduciator_verify_posting($event['mode'], $event['forum_id'], $event['post_id'], $event['post_data'], true)) {	// Posting is allowed
			$introduciator_posting_must_be_approved = $this->helper->introduciator_is_posting_must_be_approved($event['mode'], $event['data']['forum_id']);
			if ($introduciator_posting_must_be_approved) {	// If posting should not be approved, let $data['force_approved_state'] unchanged (in case of another extension has modified it)
				$data = $event['data'];
				$data['force_visibility'] = ITEM_UNAPPROVED;    // Force approval
				$data['introduciator_force_unapproved'] = $this->helper->introduciator_get_posting_approval_level($event['mode'], $event['data']['forum_id']); // Force approval
				$event['data'] = $data;
			}
		}
	}

	/**
	 * Verify if the posting is allowed or not.
	 *
	 * Called when the user submit a post.
	 * If user is not allowed to post, an error message is displayed, else if
	 * the extension has been configure with force introduce approval, set option
	 * to make this message with moderator approval.
	 *
	 * @param $event Event.
	 */
	public function on_submit_post_after($event)
	{
		$data = $event['data'];
		if (isset($data['introduciator_force_unapproved'])) {
			meta_refresh(20, $event['redirect_url']); // More time to read
			$message = $this->user->lang['POST_STORED_MOD'] . ' ' . $this->user->lang['POST_APPROVAL_NOTIFY'];
			if ($data['introduciator_force_unapproved'] == introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT) {	// Add more explanation: the user can modify his introduce
				$this->helper->load_language_if_needed();
				$message .= $this->helper->get_language()->lang('INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY');
			}
			$message .= '<br /><br />' . sprintf($this->user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . $data['forum_id']) . '">', '</a>');
			trigger_error($message);
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
	 * @param $event Event.
	 */
	public function on_submit_post_end($event)
	{
		switch ($event['mode']) {
			case 'edit_first_post':
			case 'edit_last_post':
			case 'edit':
				if ($this->helper->introduction_is_unapproved_topic($event['data']['forum_id'], $event['data']['topic_id'], false)) {
					$params = '&amp;t=' . $event['data']['topic_id'];
					$params .= '&amp;p=' . $event['data']['post_id'];
					$add_anchor = '#p' . $event['data']['post_id'];
					$url = "{$this->root_path}viewtopic.{$this->php_ext}";
					$event['url'] = append_sid($url, 'f=' . $event['data']['forum_id'] . $params) . $add_anchor;
				}
				break;
		}
	}

	/**
	 * Allow the user that create own introduction to view it into the list of the topic, changing the SQL request to get approved topic + own introduce.
	 *
	 * @param $event Event.
	 */
	public function on_get_topic_ids($event)
	{
		if (!empty($event['sql_approved'])) {
			$sql_approved = $this->helper->introduciator_generate_sql_approved_for_forum($event['forum_data']['forum_id'], $event['sql_approved'], 't');
			if ($sql_approved !== $event['sql_approved']) {	// Modified by function, should re-inject into sql statement
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
	 * @param $event Event.
	 */
	public function on_display_unapproved_question_mark($event)
	{
		if ($this->helper->introduction_is_unapproved_topic($event['row']['forum_id'], $event['row']['topic_id'], false)) {
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
	 * @param $event Event.
	 */
	public function is_topic_visible($event)
	{
		if ($event['mode'] === "topic") {
			if ($this->helper->introduction_is_unapproved_topic($event['forum_id'], $event['data']['topic_id'], false)) {
				$event['is_visible'] = true;
			}
		}
	}

	/**
	 * Allow the user that create own introduction to view it into the list of the topic, even the topic is unapproved.
	 *
	 * @param $event Event.
	 */
	public function get_topic_sql_visibility($event)
	{
		$get_visibility_sql_overwrite = null;
		if ($this->helper->get_topic_sql_visibility($event['forum_id'], $event['where_sql'], $event['mode'], $event['table_alias'], $get_visibility_sql_overwrite)) {
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
	 * Prepare row with data to display: the link to the user's introduce.
	 *
	 * @param $event Event.
	 */
	public function on_viewtopic_modify_post_row($event)
	{
		// Step1: remove approval post if needed
		if ($this->helper->introduction_is_unapproved_topic($event['topic_data']['forum_id'], $event['row']['topic_id'], false)) {
			$row = $event['post_row'];
			$row['S_POST_UNAPPROVED'] = false;
			$event['post_row'] = $row;
		}

		// Prepare data to display link to suer's introduce
		$data_introduciator = $event['user_poster_data']['datas_introduciator'];
		$event['post_row'] += [
			'S_INTRODUCIATOR_DISPLAY'	=> $data_introduciator['display'],
			'U_INTRODUCIATOR_URL'		=> $data_introduciator['url'],
			'T_INTRODUCIATOR_TEXT'		=> $data_introduciator['text'],
			'T_INTRODUCIATOR_CLASS'		=> $data_introduciator['class'],
		];
	}

	/**
	 * Called when a user whant to post, before write the message or when he choose to begin posting a new subject.
	 *
	 * Only in the INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT mode, allow the moderator to post a reply into an unapproved message.
	 *
	 * @param $event Event.
	 */
	public function on_user_want_post($event)
	{
		if ($this->helper->introduciator_let_user_posting_or_editing($event['mode'], $event['forum_id'], $event['post_data'])) {
			$data = $event['post_data'];
			$data['topic_visibility'] = ITEM_APPROVED; // Force approval
			$event['post_data'] = $data;
		}
	}

	//
	// From here, all event are used into GUI: add new templates
	//

	/**
	 * Loads all user profile introduce data into the user cache for a topic.
	 *
	 * Prepare data to be displayed in viewtopic.
	 *
	 * @param \phpbb\event\data	$event The event data
	 */
	public function on_viewtopic_modify_post_data($event)
	{
		$user_cache = $event['user_cache'];

		foreach ($event['user_cache'] as $user_id => $user_info) {
			$user_cache[$user_id]['datas_introduciator'] = $this->helper->introduciator_get_user_infos($user_id, $user_info['username']);
		}

		$event['user_cache'] = $user_cache;
	}

	/**
	 * Loads all user profile introduce data into the template_data to be displayed when it's needed.
	 *
	 * Prepare data to be displayed in several pages  like memberlist.
	 *
	 * @param \phpbb\event\data	$event The event data
	 * @return Event datas that contains informations to display into the profile.
	 */
	public function on_display_profile_data($event)
	{
		$data = $event['data'];
		$data_introduciator = $this->helper->introduciator_get_user_infos($data['user_id'], $data['username']);

		$event['template_data'] += [
			'S_INTRODUCIATOR_DISPLAY'	=> $data_introduciator['display'],
			'S_INTRODUCIATOR_PENDING'	=> $data_introduciator['pending'],
			'U_INTRODUCIATOR_URL'		=> $data_introduciator['url'],
			'T_INTRODUCIATOR_TEXT'		=> $data_introduciator['text'],
			'T_INTRODUCIATOR_CLASS'		=> $data_introduciator['class'],
		];

		return $event;
	}
}