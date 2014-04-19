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

global $phpbb_root_path, $phpEx, $table_prefix, $introduciator_params;
include($phpbb_root_path . 'includes/functions_user.' . $phpEx);

// Define own constants, could be copy into includes\constants.php
// but here, no need to edit and	 merge this source code with phpBB one.
define('INTRODUCIATOR_CURRENT_VERSION',	'1.0.0-RC2');
define('INTRODUCIATOR_CONFIG_TABLE',	$table_prefix . 'introduciator_config');
define('INTRODUCIATOR_GROUPS_TABLE',	$table_prefix . 'introduciator_groups');

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
function replace_all_by($arr_fields,$arr_replace_by)
{
	foreach ($arr_fields as &$field)
	{
		foreach ($arr_replace_by as $arr_replace_by_key => $arr_replace_by_value)
		{
			$field = str_replace($arr_replace_by_key,$arr_replace_by_value,$field);
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
function is_user_has_post_into_introduciator_topic($forum_id,$user_id,&$topic_id,&$first_post_id,&$topic_approved)
{
	global $db; // Database

	$sql = 'SELECT topic_id, topic_first_post_id, topic_approved
			FROM ' . TOPICS_TABLE . '
				WHERE topic_poster = ' . (int) $user_id . '
				 AND forum_id = ' . (int) $forum_id;
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
		array_push($arr_groups_id,$row['fk_group']);
	}
	$db->sql_freeresult($result);

	// Testing
	return group_memberships($arr_groups_id,(int) $user_id,true);
}

/**
 * Get the introduciator parameters.
 *
 * @return The introduciator parameters
 */
function introduciator_getparams()
{
	global $db; // Database

	$sql = 'SELECT *
			FROM  ' . INTRODUCIATOR_CONFIG_TABLE;
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	return $row;
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
function is_user_ignored($poster_id,$poster_name,$introduciator_params)
{
	//$auth->acl_get('u_must_introduce');
	// Check if :
	//	1 : Include group is ON and the user is member of at least one group of the selected groups (include groups)
	//	2 : Include group is OFF (exclude) and the user is not member of one group of the selected groups (exclude groups)
	$is_in_group_selected = is_user_in_groups_selected($poster_id);
	$user_ignored = true;

	// User is in selected group or out of selected group ?
	if (($introduciator_params['is_include_groups'] && $is_in_group_selected) || (!$introduciator_params['is_include_groups'] && !$is_in_group_selected))
	{
		$user_ignored = in_array(utf8_strtolower($poster_name),explode("\n", utf8_strtolower($introduciator_params['ignored_users'])));
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
function is_user_must_introduce_himself($poster_id,$authorisations,$poster_name,$introduciator_param)
{
	$ret = false;

	if ($introduciator_param['is_use_permissions'])
	{
		if ($authorisations === null)
		{
			global $db;

			$sql = 'SELECT user_id, username, user_permissions, user_type
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $poster_id;
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
		$ret = !is_user_ignored($poster_id,$poster_name,$introduciator_param);
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
 * @param $post_id Post's id : it cannot be deleted if it is the first one and action is delete
 * @param $post_data Informations about posting
 * @return None.
 */
function introduciator_verify_posting($user,$mode,$forum_id,$post_id,$post_data)
{
	global $phpbb_root_path, $phpEx, $template, $auth, $config;

	$poster_id = $user->data['user_id'];
	$forum_id = (!empty($post_data['forum_id'])) ? (int) $post_data['forum_id'] : (int) $forum_id;
	$post_id  = (!empty($post_data['post_id'])) ? (int) $post_data['post_id'] : (int) $post_id;

	if ($poster_id != ANONYMOUS && $auth->acl_get('u_'))
	{	// User is logged and have user authorization
		if ($config['allow_introduciator'])
		{	// MOD is enabled and the user is not ignored, it can do all he wants
			// Force forum id because it be moved while user delete the message
			global $db;

			$params = introduciator_getparams();

			if ($mode == 'delete')
			{	// Check if the user don't try to remove the first message of it's OWN introduce
				// Don't care about is_user_ignored / is_user_must_introduce_himself => Administrator / Moderator cannot delete first posts of presentation
				// else he needs to delete all the topic
				if (!empty($post_id)
					&& $params['fk_forum_id'] == $forum_id
					&& $params['is_check_delete_first_post_enabled']
					&& $user->data['is_registered']
					&& $auth->acl_gets('f_delete', 'm_delete', $forum_id))
				{	// This post is into the introduce forum
					// Find the topic identifier
					$sql = 'SELECT topic_id,poster_id
							FROM ' . POSTS_TABLE . '
							WHERE post_id = ' . (int) $post_id;

					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$topic_id = $row['topic_id'];
					$first_poster_id = $row['poster_id'];	// <-- $poster_id could be <> from current user id
															// It's this case when moderator try to delete post of another user
					if (!empty($topic_id) && !empty($first_poster_id))
					{	// Check if this post is the first one, ie this is the post that created the Topic
						$topic_first_post_id = (int) $post_data['topic_first_post_id'];

						if (!empty($topic_first_post_id) && $topic_first_post_id == $post_id)
						{	// The user try to delete the first post of one introduce topic : may be not allowed
							// To finish, the $first_poster_id MUST BE not ignored
							if (is_user_must_introduce_himself($first_poster_id,null,$user->data['username'],$params))
							{
								$user->setup('mods/introduciator'); // Add lang
								$message = $user->lang[($first_poster_id == $poster_id && !$auth->acl_get('m_delete', $forum_id)) ? 'INTRODUCIATOR_MOD_DELETE_INTRODUCE_MY_FIRST_POST' : 'INTRODUCIATOR_MOD_DELETE_INTRODUCE_FIRST_POST'];
								$meta_info = append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f=$forum_id&amp;t=$topic_id");
								$message .= '<br/><br/>' . sprintf($user->lang['RETURN_TOPIC'], '<a href="' . $meta_info . '">', '</a>');
								$message .= '<br/><br/>' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", "f=$forum_id") . '">', '</a>');
								// meta_refresh(3, $meta_info); // Go back automatically to topic <- Not for the moment
								trigger_error($message,E_USER_NOTICE);
							}
						}
					}
				}
			}
			else if (is_user_must_introduce_himself($poster_id,$auth,$user->data['username'],$params))
			{
				$topic_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				if (!is_user_has_post_into_introduciator_topic($params['fk_forum_id'],$poster_id,$topic_id,$first_post_id,$topic_approved))
				{	// No post into the introduce topic
					if ((in_array($mode,array('reply', 'quote')) || ($mode == 'post' && $forum_id != $params['fk_forum_id'])))
					{
						if ($params['is_explanation_enabled'])
						{
							redirect(append_sid("{$phpbb_root_path}/introduciator_explain.$phpEx", 'f=' . $params['fk_forum_id']));
						}
						else
						{
							redirect(append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $params['fk_forum_id']));
						}
					}
				}
				else if (!$topic_approved && in_array($mode,array('reply', 'quote','post')))
				{	// At least one post but not approved !
					$user->setup('mods/introduciator'); // Add lang
					$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_WAITING_APPROBATION'];
					$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id) . '">', '</a>');
					trigger_error($message,E_USER_NOTICE);
				}
				else if ($forum_id == $params['fk_forum_id'] && $mode == 'post')
				{	// User try to create more than one introduce post
					$user->setup('mods/introduciator'); // Add lang
					$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'];
					$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id) . '">', '</a>');
					trigger_error($message,E_USER_NOTICE);
				}
			}
		}
	}
}

/**
 * Verify if the posting is allowed or not.
 *
 * If not allowed, it redirect the current page to the introduce forum or the explanation page
 * or error message if action is not allowed.
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
function introduciator_get_user_infos($poster_id,$poster_name)
{
	global $phpbb_root_path, $phpEx, $user, $introduciator_params, $auth;

	$display = false;
	$url = false;
	$text = '';
	$class = '';
	$pending = false;

	if ($config['allow_introduciator'])
	{
		if (empty($introduciator_params))
		{
			$introduciator_params = introduciator_getparams();
			$user->add_lang('mods/introduciator');
		}

		if (is_user_must_introduce_himself($poster_id,$auth,$poster_name,$introduciator_params))
		{
			$display = true;
			$topic_id = 0;
			$first_post_id = 0;
			$topic_approved = false;

			if (!is_user_has_post_into_introduciator_topic($introduciator_params['fk_forum_id'],$poster_id,$topic_id,$first_post_id,$topic_approved))
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
				$class = 'introdpd-icon';
				$pending = true;
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

?>