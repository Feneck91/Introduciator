<?php
/**
*
* @package Introduciator MOD
* @author Feneck91 (Stéphane Château) feneck91@free.fr
* @version $Id$
* @copyright (c) 2013 @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Documentation : https://wiki.phpbb.com/Creating_modules
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $table_prefix;
// Define own constants, could be copy into includes\constants.php
// but here, no need to edit and merge this source code with phpBB one.
define('INTRODUCIATOR_CURRENT_VERSION',		'1.0.0');
define('INTRODUCIATOR_GROUPS_TABLE',		$table_prefix . 'introduciator_groups');

if (!function_exists('group_memberships'))
{
	global $phpbb_root_path, $phpEx;
	include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
}

// Define own constants
define('INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL',			0);	// No approval introduce
define('INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL',				1); // Approval introduce : the user don't see his introduce and cannot edit it
define('INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT',	2); // Approval introduce : the user see his introduce and can edit it

/**
 * Check if a group is selected.
 *
 * @param $forum_id Forum's identifier.
 * @return true if the group is selected, false else.
 */
function is_group_selected($forum_id)
{
	global $db; // Database

	$sql = 'SELECT *
			FROM ' . INTRODUCIATOR_GROUPS_TABLE . '
			WHERE fk_group = ' . (int) $forum_id;

	$result = $db->sql_query($sql);
	$ret = false;
	while ($row = $db->sql_fetchrow($result))
	{
		$ret = true;
	}
	$db->sql_freeresult($result);

	return $ret;
}

/**
 * Replace all variables with several values.
 *
 * Example :
 * 	replace_all_by(
 *		array(
 *			&$var_1,
 *			&$var_2
 *			),
 *		array(
 *			'search1'	=> 'replaced by this text1',
 *			'search2'	=> 'replaced by this text2',
 *			'search3'	=> 'replaced by this text3',
 *			));
 *
 * @param $arr_fields Array of variables to update
 * @param $arr_replace_by Array of maps with key is the text to replace, value is the text to replace with
 * @return None
 */
function replace_all_by($arr_fields, $arr_replace_by)
{
	foreach ($arr_fields as &$field)
	{
		foreach ($arr_replace_by as $arr_replace_by_key => $arr_replace_by_value)
		{
			$field = str_replace($arr_replace_by_key, $arr_replace_by_value, $field);
		}
	}
}

/**
 * Check if the user have already posted into this forum.
 *
 * It must be the creator of one topic into the configured forum.
 *
 * @param type $forum_id Forum's ID
 * @param type $user_id User's ID
 * @param $topic_id If this function returns true, it contains the Topic ID where the user hast post it's presentation
 * @param $first_post_id If this function returns true, it contains the post ID of the post that has created the topic
 * @param $topic_approved If this function returns true, it contains true / false if the topic is approved or not
 * @return true if the user already post at least one message into this forum, false else
 */
function is_user_post_into_forum($forum_id, $user_id, &$topic_id, &$first_post_id, &$topic_approved)
{
	global $db; // Database

	$sql = 'SELECT topic_id, topic_first_post_id, topic_approved
			FROM ' . TOPICS_TABLE . '
				WHERE topic_poster = ' . (int) $user_id . '
				 AND forum_id = ' . (int) $forum_id . '
				 AND topic_first_post_id <> 0'; // PATCH : Sometimes, the topic_first_post_id is 0
	$result = $db->sql_query($sql);
	$topic_row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	if ($topic_row !== false)
	{
		$topic_id = $topic_row['topic_id'];
		$first_post_id = $topic_row['topic_first_post_id'];
		$topic_approved = $topic_row['topic_approved'];
	}

	return $topic_row !== false; // Return true or false
}

/**
 * Test if one of the user's groups has been selected into configuration.
 *
 * These groups are selected into ACP, recorded into INTRODUCIATOR_GROUPS_TABLE table.
 * Call group_memberships function into includes/functions_user.php file.
 *
 * @param $user_id User identifier into database
 * @return true if one of the user's group has been selected into configuration, false else
 */
function is_user_in_groups_selected($user_id)
{
	global $db;			// Database

	$sql = 'SELECT *
			FROM ' . INTRODUCIATOR_GROUPS_TABLE;
	$result = $db->sql_query($sql);

	// Construct an array of group ID present into INTRODUCIATOR_GROUPS_TABLE table
	$arr_groups_id = array();
	while ($row = $db->sql_fetchrow($result))
	{	// Merge array
		array_push($arr_groups_id, $row['fk_group']);
	}
	$db->sql_freeresult($result);

	// Testing
	return group_memberships($arr_groups_id, (int) $user_id, true);
}

/**
 * Get the introduciator parameters.
 *
 * @param $is_edit if true, return rules texts for editing
 *                 if false, return rules texts for display
 *                 if null, don't return rules texts (used only in the MOD configuration and to display rules
 * @return The introduciator parameters
 */
function introduciator_getparams($is_edit = null)
{
	global $config;

	$params = array(
		'introduciator_allow'					=> isset($config['introduciator_allow']) && $config['introduciator_allow'] != '' ? $config['introduciator_allow'] : false,
		'fk_forum_id'							=> isset($config['introduciator_fk_forum_id']) &&  $config['introduciator_fk_forum_id'] != '' ? $config['introduciator_fk_forum_id'] : 0,
		'is_check_delete_first_post'			=> isset($config['introduciator_is_check_delete_first_post']) && $config['introduciator_is_check_delete_first_post'] != '' ? $config['introduciator_is_check_delete_first_post'] : true,
		'is_explanation_enabled'				=> isset($config['introduciator_is_explanation_enabled']) && $config['introduciator_is_explanation_enabled'] != '' ? $config['introduciator_is_explanation_enabled'] : true,
		'is_use_permissions'					=> isset($config['introduciator_is_use_permissions']) && $config['introduciator_is_use_permissions'] != '' ? $config['introduciator_is_use_permissions'] : true,
		'is_include_groups'						=> isset($config['introduciator_is_include_groups']) && $config['introduciator_is_include_groups'] != '' ? $config['introduciator_is_include_groups'] : true,
		'ignored_users'							=> isset($config['introduciator_ignored_users']) && $config['introduciator_ignored_users'] != '' ? $config['introduciator_ignored_users'] : '',
		'is_explanation_display_rules'			=> isset($config['introduciator_is_explanation_display_rules']) && $config['introduciator_is_explanation_display_rules'] != '' ? $config['introduciator_is_explanation_display_rules'] : true,
		'posting_approval_level'				=> isset($config['introduciator_posting_approval_level']) && $config['introduciator_posting_approval_level'] != '' ? $config['introduciator_posting_approval_level'] : 0,
	);

	if ($is_edit === true || $is_edit === false)
	{
		$explanation_message_title						= isset($config['introduciator_explanation_message_title']) && $config['introduciator_explanation_message_title'] != '' ? $config['introduciator_explanation_message_title'] : '';
		$explanation_message_title_uid					= isset($config['introduciator_explanation_message_title_uid']) && $config['introduciator_explanation_message_title_uid'] != '' ? $config['introduciator_explanation_message_title_uid'] : '';
		$explanation_message_title_bitfield				= isset($config['introduciator_explanation_message_title_bitfield']) && $config['introduciator_explanation_message_title_bitfield'] != '' ? $config['introduciator_explanation_message_title_bitfield'] : '';
		$explanation_message_title_bbcode_options		= isset($config['introduciator_explanation_message_title_bbcode_options']) && $config['introduciator_explanation_message_title_bbcode_options'] != '' ? $config['introduciator_explanation_message_title_bbcode_options'] : '';
		$explanation_message_text						= isset($config['introduciator_explanation_message_text']) && $config['introduciator_explanation_message_text'] != '' ? $config['introduciator_explanation_message_text'] : '';
		$explanation_message_text_uid					= isset($config['introduciator_explanation_message_text_uid']) && $config['introduciator_explanation_message_text_uid'] != '' ? $config['introduciator_explanation_message_text_uid'] : '';
		$explanation_message_text_bitfield				= isset($config['introduciator_explanation_message_text_bitfield']) && $config['introduciator_explanation_message_text_bitfield'] != '' ? $config['introduciator_explanation_message_text_bitfield'] : '';
		$explanation_message_text_bbcode_options		= isset($config['introduciator_explanation_message_text_bbcode_options']) && $config['introduciator_explanation_message_text_bbcode_options'] != '' ? $config['introduciator_explanation_message_text_bbcode_options'] : '';
		$explanation_message_rules_title				= isset($config['introduciator_explanation_message_rules_title']) && $config['introduciator_explanation_message_rules_title'] != '' ? $config['introduciator_explanation_message_rules_title'] : '';
		$explanation_message_rules_title_uid			= isset($config['introduciator_explanation_message_rules_title_uid']) && $config['introduciator_explanation_message_rules_title_uid'] != '' ? $config['introduciator_explanation_message_rules_title_uid'] : '';
		$explanation_message_rules_title_bitfield		= isset($config['introduciator_explanation_message_rules_title_bitfield']) && $config['introduciator_explanation_message_rules_title_bitfield'] != '' ? $config['introduciator_explanation_message_rules_title_bitfield'] : '';
		$explanation_message_rules_title_bbcode_options	= isset($config['introduciator_explanation_message_rules_title_bbcode_options']) && $config['introduciator_explanation_message_rules_title_bbcode_options'] != '' ? $config['introduciator_explanation_message_rules_title_bbcode_options'] : '';
		$explanation_message_rules_text					= isset($config['introduciator_explanation_message_rules_text']) && $config['introduciator_explanation_message_rules_text'] != '' ? $config['introduciator_explanation_message_rules_text'] : '';
		$explanation_message_rules_text_uid				= isset($config['introduciator_explanation_message_rules_text_uid']) && $config['introduciator_explanation_message_rules_text_uid'] != '' ? $config['introduciator_explanation_message_rules_text_uid'] : '';
		$explanation_message_rules_text_bitfield		= isset($config['introduciator_explanation_message_rules_text_bitfield']) && $config['introduciator_explanation_message_rules_text_bitfield'] != '' ? $config['introduciator_explanation_message_rules_text_bitfield'] : '';
		$explanation_message_rules_text_bbcode_options	= isset($config['introduciator_explanation_message_rules_text_bbcode_options']) && $config['introduciator_explanation_message_rules_text_bbcode_options'] != '' ? $config['introduciator_explanation_message_rules_text_bbcode_options'] : '';
		
		$forum_name = '';
		$forum_rules = array();

		if ($params['introduciator_allow'])
		{	// Find Forum name
			global $db;

			$sql = 'SELECT forum_name, forum_rules, forum_rules_uid, forum_rules_bitfield, forum_rules_options
					FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . (int) $params['fk_forum_id'];
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);

			if ($row)
			{
				$forum_name = $row['forum_name'];
				$forum_rules = array(
					'rules'				=> $row['forum_rules'],
					'rules_uid'			=> $row['forum_rules_uid'],
					'rules_bitfield'	=> $row['forum_rules_bitfield'],
					'rules_options'		=> $row['forum_rules_options'],
				);
			}
			$db->sql_freeresult($result);
		}

		if ($is_edit === true)
		{
			$explanation_message_title = generate_text_for_edit($explanation_message_title, $explanation_message_title_uid, $explanation_message_title_bbcode_options);
			$explanation_message_text = generate_text_for_edit($explanation_message_text, $explanation_message_text_uid, $explanation_message_text_bbcode_options);
			$explanation_message_rules_title = generate_text_for_edit($explanation_message_rules_title, $explanation_message_rules_title_uid, $explanation_message_rules_title_bbcode_options);
			$explanation_message_rules_text = generate_text_for_edit($explanation_message_rules_text, $explanation_message_rules_text_uid, $explanation_message_rules_text_bbcode_options);

			$explanation_message_title = $explanation_message_title['text'];
			$explanation_message_text = $explanation_message_text['text'];
			$explanation_message_rules_title = $explanation_message_rules_title['text'];
			$explanation_message_rules_text = $explanation_message_rules_text['text'];
			
			// Restore %forum_url% and %forum_post% tags because we must change them else the BBCode URL not work if the URL is not correct
			replace_all_by(
				array(
					&$explanation_message_title,
					&$explanation_message_text,
					&$explanation_message_rules_title,
					&$explanation_message_rules_text,
				),
				array(
					'http&#58;//aghxkfps&#46;com'	=> '%forum_url%',
					'http&#58;//dqsdfzef&#46;com'	=> '%forum_post%',
				));
			
			$params = array_merge($params, array(
				'explanation_message_title'				=> $explanation_message_title,
				'explanation_message_text'				=> $explanation_message_text,
				'explanation_message_rules_title'		=> $explanation_message_rules_title,
				'explanation_message_rules_text'		=> $explanation_message_rules_text,
			));
		}
		else
		{
			global $user, $phpbb_root_path, $phpEx;

			// Load langage
			$user->add_lang('mods/introduciator');

			// Generate all string to be displayed
			$explanation_message_title = generate_text_for_display($explanation_message_title, $explanation_message_title_uid, $explanation_message_title_bitfield, $explanation_message_title_bbcode_options);
			$explanation_message_text = generate_text_for_display($explanation_message_text, $explanation_message_text_uid, $explanation_message_text_bitfield, $explanation_message_text_bbcode_options);
			$explanation_message_rules_title = generate_text_for_display($explanation_message_rules_title, $explanation_message_rules_title_uid, $explanation_message_rules_title_bitfield, $explanation_message_rules_title_bbcode_options);
			$explanation_message_rules_text = generate_text_for_display($explanation_message_rules_text, $explanation_message_rules_text_uid, $explanation_message_rules_text_bitfield, $explanation_message_rules_text_bbcode_options);
			$explanation_message_rules_text = str_replace('%rules_text%', generate_text_for_display($forum_rules['rules'], $forum_rules['rules_uid'], $forum_rules['rules_bitfield'], $forum_rules['rules_options']), $explanation_message_rules_text);
			$explanation_message_title = str_replace('%explanation_title%', $user->lang['INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TITLE'], $explanation_message_title);
			$explanation_message_text = str_replace('%explanation_text%', $user->lang['INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TEXT'] . (($params['is_explanation_display_rules'] && strlen($explanation_message_text) > 0 && strlen($explanation_message_rules_text) > 0) ? $user->lang['INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TEXT_RULES'] : ''), $explanation_message_text);
			$explanation_message_rules_title = str_replace('%rules_title%', $user->lang['INTRODUCIATOR_MOD_DEFAULT_RULES_TITLE'], $explanation_message_rules_title);
			$link_goto_forum = $user->lang['INTRODUCIATOR_MOD_DEFAULT_LINK_GOTO_FORUM'];
			$link_post_forum = $user->lang['INTRODUCIATOR_MOD_DEFAULT_LINK_POST_FORUM'];

			$forum_url = append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $params['fk_forum_id']);
			$forum_post = append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=post&amp;f=' . $params['fk_forum_id']);

			// Replace in each string the predefined fields
			replace_all_by(
				array(
					&$explanation_message_title,
					&$explanation_message_text,
					&$explanation_message_rules_title,
					&$explanation_message_rules_text,
				),
				array(
					'%forum_name%'			=> $forum_name,
					'http://aghxkfps.com'	=> $forum_url,	// Restore correct link
					'http://dqsdfzef.com'	=> $forum_post,	// Restore correct link
				)
			);

			// Make links into $link_goto_forum / $link_post_forum
			replace_all_by(
				array(
					&$explanation_message_title,		// if text is from $user->lang[xx],  
					&$explanation_message_text,
					&$explanation_message_rules_title,
					&$explanation_message_rules_text,
					&$link_goto_forum,
					&$link_post_forum,
				),
				array(
					'%forum_name%'	=> $forum_name,
					'%forum_url%'	=> $forum_url,
					'%forum_post%'	=> $forum_post,
				)
			);
					
			$params = array_merge($params, array(
				'explanation_message_title'				=> $explanation_message_title,
				'explanation_message_text'				=> $explanation_message_text,
				'explanation_message_rules_title'		=> $explanation_message_rules_title,
				'explanation_message_rules_text'		=> $explanation_message_rules_text,
				'explanation_message_goto_forum'		=> $link_goto_forum,
				'explanation_message_post_forum'		=> $link_post_forum,
				'forum_name'							=> $forum_name,
				'forum_url'								=> $forum_url,
				'forum_post'							=> $forum_post,
			));
		}
	}

	return $params;
}

/**
 * Check if the user is ignored or must introduce himself.
 *
 * Check if it contains include groups or if doesn't contains exclude group.
 * Check if it doesn't contains name of ignored username list.
 *
 * @param $poster_id User's ID
 * @param $poster_name User's name
 * @param $introduciator_params Introduce MOD parameters
 * @return true if the user is ignored, false else
 */
function is_user_ignored($poster_id, $poster_name, $introduciator_params)
{
	// Check if :
	//	1 : Include group is ON and the user is member of at least one group of the selected groups (include groups)
	//	2 : Include group is OFF (exclude) and the user is not member of one group of the selected groups (exclude groups)
	$is_in_group_selected = is_user_in_groups_selected($poster_id);
	$user_ignored = true;

	// User is in selected group or out of selected group ?
	if (($introduciator_params['is_include_groups'] && $is_in_group_selected) || (!$introduciator_params['is_include_groups'] && !$is_in_group_selected))
	{
		$user_ignored = in_array(utf8_strtolower($poster_name), explode("\n", utf8_strtolower($introduciator_params['ignored_users'])));
	}

	return $user_ignored;
}

/**
 * Check if the user is ignored or must introduce himself.
 *
 * Check if it contains include groups or if doesn't contains exclude group.
 * Check if it doesn't contains name of ignored username list.
 *
 * @param $poster_id User's ID
 * @param $authorisations User's authorisations
 * @param $poster_name User's name
 * @param $introduciator_params Introduce MOD parameters
 * @return true if the user must introduce himself pending of rights, false else
 */
function is_user_must_introduce_himself($poster_id, $authorisations, $poster_name, $introduciator_param)
{
	$ret = false;

	if ($introduciator_param['is_use_permissions'])
	{
		if ($authorisations === null)
		{
			global $db;

			$sql = 'SELECT user_id, username, user_permissions, user_type
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $poster_id;
			$result = $db->sql_query($sql);
			$userdata = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$userdata)
			{
				trigger_error('NO_USERS', E_USER_ERROR);
			}

			$authorisations = new auth();
			$authorisations->acl($userdata);
		}

		$ret = $authorisations->acl_get('u_must_introduce');
	}
	else
	{
		$ret = !is_user_ignored($poster_id, $poster_name, $introduciator_param);
	}

	return $ret;
}

/**
 * Verify if the posting is allowed or not.
 *
 * If not allowed, it redirect the current page to the introduce forum or the explanation page
 * or error message if action is not allowed.
 *
 * @param $poster_id The poster id
 * @param $mode posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc
 * @param $forum_id Forum identifier where the user try to post
 * @param $post_id Post's id : it cannot be deleted if it is the first one and action is delete (used only for delete), pass 0 else.
 * @param $post_data Informations about posting (used only for delete) pass null else.
 * @param $redirect true if the function should redirect in case of the user is not allowed to make the action, else only return status.
 * @return true if the user is allowed to make action, false else.
 */
function introduciator_verify_posting($user, $mode, $forum_id, $post_id, $post_data, $redirect = true)
{
	global $phpbb_root_path, $phpEx, $template, $auth, $config;

	$poster_id = (int) $user->data['user_id'];
	$ret_allowed_action = true;

	if ($poster_id != ANONYMOUS)
	{	// User is logged and have user authorization
		if ($config['introduciator_allow'])
		{	// MOD is enabled and the user is not ignored, it can do all he wants
			// Force forum id because it be moved while user delete the message
			global $db, $introduciator_params;

			if (empty($introduciator_params))
			{
				$introduciator_params = introduciator_getparams();
				if (empty($user->lang['RETURN_FORUM']))
				{
					$user->setup('mods/introduciator');		// Setup & Add lang
				}
				else
				{
					$user->add_lang('mods/introduciator');	// Add lang
				}
			}

			if ($mode == 'delete')
			{	// Check if the user don't try to remove the first message of it's OWN introduce
				// Don't care about is_user_ignored / is_user_must_introduce_himself => Administrator / Moderator cannot delete first posts of presentation
				// else he needs to delete all the topic
				$forum_id = (!empty($post_data['forum_id'])) ? (int) $post_data['forum_id'] : (int) $forum_id;
				$post_id  = (!empty($post_data['post_id'])) ? (int) $post_data['post_id'] : (int) $post_id;
				if (!empty($post_id) && !empty($post_data['topic_id']) && $introduciator_params['fk_forum_id'] == $forum_id && $introduciator_params['is_check_delete_first_post'] && $user->data['is_registered'] && $auth->acl_gets('f_delete', 'm_delete', $forum_id))
				{	// This post is into the introduce forum
					// Find the topic identifier
					$sql = 'SELECT topic_id, poster_id
							FROM ' . POSTS_TABLE . '
							WHERE post_id = ' . (int) $post_id;

					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$topic_id = (int) $row['topic_id'];
					$first_poster_id = (int) $row['poster_id'];	// <-- $poster_id could be <> from current user id
																// It's this case when moderator try to delete post of another user
					if (!empty($topic_id) && !empty($first_poster_id))
					{	// Check if this post is the first one, ie this is the post that created the Topic
						$topic_first_post_id = (int) $post_data['topic_first_post_id'];

						if (!empty($topic_first_post_id) && $topic_first_post_id == $post_id)
						{	// The user try to delete the first post of one introduce topic : may be not allowed
							// To finish, the $first_poster_id MUST BE not ignored
							if (is_user_must_introduce_himself($first_poster_id, null, $user->data['username'], $introduciator_params))
							{
								$ret_allowed_action = false;
								if ($redirect)
								{
									$message = $user->lang[($first_poster_id == $poster_id && !$auth->acl_get('m_delete', $forum_id)) ? 'INTRODUCIATOR_MOD_DELETE_INTRODUCE_MY_FIRST_POST' : 'INTRODUCIATOR_MOD_DELETE_INTRODUCE_FIRST_POST'];
									$meta_info = append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f=$forum_id&amp;t=$topic_id");
									$message .= '<br/><br/>' . sprintf($user->lang['RETURN_TOPIC'], '<a href="' . $meta_info . '">', '</a>');
									$message .= '<br/><br/>' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", "f=$forum_id") . '">', '</a>');
									trigger_error($message, E_USER_NOTICE);
								}
							}
						}
					}
				}
			}
			else if (is_user_must_introduce_himself($poster_id, $auth, $user->data['username'], $introduciator_params))
			{
				$topic_introduce_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				if (!is_user_post_into_forum($introduciator_params['fk_forum_id'], $poster_id, $topic_introduce_id, $first_post_id, $topic_approved))
				{	// No post into the introduce topic
					if ((in_array($mode, array('reply', 'quote')) || ($mode == 'post' && $forum_id != $introduciator_params['fk_forum_id'])))
					{
						$ret_allowed_action = false;
						if ($redirect)
						{
							if ($introduciator_params['is_explanation_enabled'])
							{
								redirect(append_sid("{$phpbb_root_path}/introduciator_explain.$phpEx", 'f=' . $introduciator_params['fk_forum_id']));
							}
							else
							{
								redirect(append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $introduciator_params['fk_forum_id']));
							}
						}
					}
				}
				else if (!$topic_approved && in_array($mode, array('reply', 'quote', 'post')))
				{	// At least one post but not approved !
					if (!in_array($mode, array('reply', 'quote')) || !$auth->acl_get('m_approve', $forum_id) || $introduciator_params['fk_forum_id'] != $forum_id || $introduciator_params['posting_approval_level'] != INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
					{	// Can quote / reply if the user is allowed to approval this introduction (moderator) -> Right of reply or quote is done by the framework,
						// here we just test if right are approve to don't show next message : here, the right are not correct => display the message
						$ret_allowed_action = false;
					}

					if (!$ret_allowed_action && $redirect)
					{
						// Test : if the user try to quote / reply into his own introduction : change the message
						if (!empty($post_data['topic_id']) && $post_data['topic_id'] == $topic_introduce_id)
						{
							$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'];
						}
						else
						{
							$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_WAITING_APPROBATION'];
						}
						$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id) . '">', '</a>');
						trigger_error($message, E_USER_NOTICE);
					}
				}
				else if ($forum_id == $introduciator_params['fk_forum_id'] && $mode == 'post')
				{	// User try to create more than one introduce post
					$ret_allowed_action = false;
					if ($redirect)
					{
						$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'];
						$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id) . '">', '</a>');
						trigger_error($message, E_USER_NOTICE);
					}
				}
			}
		}
	}

	return $ret_allowed_action;
}

/**
 * Get informations about the user.
 *
 * Is used by several pages to display link to the member presentation. It indicate if the user has introduce himself or not,
 * the text and tooltip info, etc.
 *
 * @param $poster_id The poster id
 * @param $poster_name The poster name
 * @return Array with :
 * <ul>
 *   <li>display : true if the user must introduce himself, false else.</li>
 *   <li>url : url to member introduction, empty string if user has no presentation.</li>
 *   <li>text : Text used to display the tooltip for the button.</li>
 *   <li>class : class to use for the button.</li>
 *   <li>pending : true if message is pending approval, false else.</li>
 * </ul>.
 */
function introduciator_get_user_infos($poster_id, $poster_name)
{
	global $phpbb_root_path, $phpEx, $user, $introduciator_params, $auth, $config;

	$display = false;
	$url = false;
	$text = '';
	$class = '';
	$pending = false;

	if ($config['introduciator_allow'])
	{
		if (empty($introduciator_params))
		{
			$introduciator_params = introduciator_getparams();
			$user->add_lang('mods/introduciator');
		}

		if (is_user_must_introduce_himself($poster_id, $auth, $poster_name, $introduciator_params))
		{
			$display = true;
			$topic_id = 0;
			$first_post_id = 0;
			$topic_approved = false;

			if (!is_user_post_into_forum($introduciator_params['fk_forum_id'], $poster_id, $topic_id, $first_post_id, $topic_approved))
			{	// No post into the introduce topic
				$text = $user->lang['INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'];
				$class = 'introdno-icon';
			}
			else if ($topic_approved)
			{
				$text = $user->lang['INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'];
				$url = append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $introduciator_params['fk_forum_id'] . '&amp;t=' . $topic_id . '#p' . $first_post_id);
				$class = 'introd-icon';
			}
			else
			{
				$text = $user->lang['INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'];
				$pending = true;
				if ($auth->acl_get('m_approve', $introduciator_params['fk_forum_id']) || ($introduciator_params['posting_approval_level'] == INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT && $poster_id == (int) $user->data['user_id']))
				{	// Display url if user can approve the introduction of this user
					// or if the current user is the poster (the user can see its own presentation) AND the MOD configuration is INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT
					$url = append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $introduciator_params['fk_forum_id'] . '&amp;t=' . $topic_id . '#p' . $first_post_id);
					$class = 'introdpu-icon';
				}
				else
				{
					$class = 'introdpd-icon';
				}
			}
		}
	}

	return array(
		'display'		=> $display,
		'url'			=> $url,
		'text'			=> $text,
		'class'			=> $class,
		'pending'		=> $pending,
	);
}

/**
 * Get the approval level for the post.
 *
 * @param $user The user informations
 * @param $mode posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc
 * @param $forum_id Forum identifier where the user try to post
 * @return The approval level for this post, depending of MOD configuration.
 */
function introduciator_get_posting_approval_level($user, $mode, $forum_id)
{
	global $auth, $config;

	$poster_id = (int) $user->data['user_id'];
	$ret_posting_approval_level = INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL;

	if ($poster_id != ANONYMOUS)
	{	// User is logged and have user authorization
		if ($config['introduciator_allow'])
		{	// MOD is enabled and the user is not ignored, it can do all he wants
			// Force forum id because it be moved while user delete the message
			$params = introduciator_getparams();

			if (is_user_must_introduce_himself($poster_id, $auth, $user->data['username'], $params))
			{
				$topic_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				if (!is_user_post_into_forum($params['fk_forum_id'], $poster_id, $topic_id, $first_post_id, $topic_approved))
				{	// No post into the introduce topic
					if ($mode == 'post' && $forum_id == $params['fk_forum_id'] && ($params['posting_approval_level'] == INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL || $params['posting_approval_level'] == INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT))
					{
						$ret_posting_approval_level = $params['posting_approval_level'];
					}
				}
			}
		}
	}

	return $ret_posting_approval_level;
}

/**
 * Verify if the posting is must be approved or not.
 *
 * If the user that post have right to approved it's own presentation,
 * the function return always false: no need to make massage approval to a user
 * that can approve himself its own message.
 * 
 * @param $user The user informations
 * @param $mode posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc
 * @param $forum_id Forum identifier where the user try to post
 * @return true if the post must be approved, false else.
 */
function introduciator_is_posting_must_be_approved($user, $mode, $forum_id)
{
	global $auth;
	return !$auth->acl_get('m_approve', $forum_id) && introduciator_get_posting_approval_level($user, $mode, $forum_id) != INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL;
}

/**
 * Check if the user try to reply / quote to an unapproved message.
 * 
 * Usually, no user is able to reply / quote to an unapproved message. When trying,
 * an error message indicate that the user is not able to do this action.
 * This function test if the mode is INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT and
 * if the logged user have the capability to approved the message, and the message is a presentation
 * message. In this case, the error message is bypass.
 * 
 * @param type $user Logged user informations
 * @param type $forum_id Forum's ID
 * @param $mode Current reply mode (quote / bump / reply)
 * @return true if the error message should be bypassed, false else.
 */
function introduciator_ignore_topic_unapproved($user, $forum_id, $mode)
{
	global $introduciator_params, $config, $auth;

	$ret = false;
	if ($config['introduciator_allow'])
	{	// Introduciator is activated and $sql_approved has filter
		if (empty($introduciator_params))
		{	// Retrieve MOD parameters
			$introduciator_params = introduciator_getparams();
			if (empty($user->lang['RETURN_FORUM']))
			{
				$user->setup('mods/introduciator');		// Setup & Add lang
			}
			else
			{
				$user->add_lang('mods/introduciator');	// Add lang
			}
		}

		if (in_array($mode, array('reply', 'quote')) && $auth->acl_get('m_approve', $forum_id) && $introduciator_params['fk_forum_id'] == $forum_id && $introduciator_params['posting_approval_level'] == INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
		{	// Into the introduce forum, the moderator can approve this message and can edit / reply
			$ret = true;
		}
	}
	
	return $ret;
}

/**
 * Generate the request to make topic visible to user when the topic owned by the user and is into
 * approval state (only for INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT configuration).
 *
 * @param $user The user informations
 * @param $forum_id Forum identifier to be displayed or null to don't filter on forum's id
 * @param $sql_approved Current sql approved.
 * @param $table_name Table name used for SQL request, it can be 't' ou 'p' or other. Empty if not needed.
 * @return The SQL modified request to be able to see the unapproved user presentation.
 */
function introduciator_generate_sql_approved_for_forum($user, $forum_id, $sql_approved, $table_name, &$approve_fid_ary = null)
{
	global $introduciator_params, $config, $auth;

	if (!empty($sql_approved) && $config['introduciator_allow'])
	{	// Introduciator is activated and $sql_approved has filter
		if (empty($introduciator_params))
		{	// Retrieve MOD parameters
			$introduciator_params = introduciator_getparams();
			if (empty($user->lang['RETURN_FORUM']))
			{
				$user->setup('mods/introduciator');		// Setup & Add lang
			}
			else
			{
				$user->add_lang('mods/introduciator');	// Add lang
			}
		}
		
		if (($forum_id === null || $introduciator_params['fk_forum_id'] == $forum_id) && $introduciator_params['posting_approval_level'] == INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
		{
			$poster_id = (int) $user->data['user_id'];
			if (is_user_must_introduce_himself($poster_id, $auth, $user->data['username'], $introduciator_params))
			{
				$topic_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				if (is_user_post_into_forum($introduciator_params['fk_forum_id'], $poster_id, $topic_id, $first_post_id, $topic_approved))
				{	// Post into this introduce topic
					if (!$topic_approved)
					{
						$sql_approved = str_replace('AND ', 'AND (', $sql_approved) . ' OR ' . (empty($table_name) ? '' : $table_name . '.') . 'topic_id = ' . (int) $topic_id . ')';
						if ($approve_fid_ary !== null)
						{
							$approve_fid_ary = array($topic_id);
						}
					}
				}
			}
		}
	}

	return $sql_approved;
}

/**
 * Test if the topic into the forum is unapproved and contains current introduce of logged user.
 *
 * This function is used only for INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT level.
 * 
 * @param $user The user informations
 * @param $forum_id Forum identifier
 * @param $topic_id topic identifier
 * @return true if the topic_id is the presentation of the logged user and is not yet approved.
 */
function introduciator_is_topic_in_forum_is_unapproved_for_introduction($user, $forum_id, $topic_id)
{
	global $introduciator_params, $config, $auth;

	$ret = false;
	if ($config['introduciator_allow'])
	{	// Introduciator is activated
		if (empty($introduciator_params))
		{	// Retrieve MOD parameters
			$introduciator_params = introduciator_getparams();
			if (empty($user->lang['RETURN_FORUM']))
			{
				$user->setup('mods/introduciator');		// Setup & Add lang
			}
			else
			{
				$user->add_lang('mods/introduciator');	// Add lang
			}
		}

		if ($introduciator_params['fk_forum_id'] == $forum_id && $introduciator_params['posting_approval_level'] == INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
		{
			$poster_id = (int) $user->data['user_id'];
			if (is_user_must_introduce_himself($poster_id, $auth, $user->data['username'], $introduciator_params))
			{
				$topic_introduce_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				if (is_user_post_into_forum($introduciator_params['fk_forum_id'], $poster_id, $topic_introduce_id, $first_post_id, $topic_approved))
				{	// Post into this introduce forum, retrieve informations about topic_id and topic approved or not
					if (!$topic_approved && $topic_id == $topic_introduce_id)
					{	// This topic is unaproved and is the introduce of the current logged user
						$ret = true;
					}
				}
			}
		}
	}
	
	return $ret;
}
?>