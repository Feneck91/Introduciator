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

global $phpbb_root_path, $phpEx, $table_prefix;
include($phpbb_root_path . 'includes/functions_user.' . $phpEx);

// Define own constants, could be copy into includes\constants.php
// but here, no need to edit and	 merge this source code with phpBB one.
define('INTRODUCIATOR_CURRENT_VERSION',	'0.9.0');
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
			WHERE fk_group = ' . $forum_id;

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
 * @param type $forum_id Forum's ID
 * @param type $user_id User's ID
 * @return true if the user already post at least one message into this forum, false else
 */
function is_user_has_post_into_introduciator_topic($forum_id,$user_id)
{
	global $db; // Database

	$sql = 'SELECT topic_id
			FROM ' . TOPICS_TABLE . '
				WHERE topic_poster = ' . $user_id . '
				 AND forum_id = ' . $forum_id;
	$result = $db->sql_query($sql);
	$topic_row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

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
	return group_memberships($arr_groups_id,$user_id,true);
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
	$ret = true;

	// Check if :
	//	1 : Include group is ON and the user is member of at least one group of the selected groups (include groups)
	//	2 : Include group is OFF (exclude) and the user is not member of one group of the selected groups (exclude groups)
	$is_in_group_selected = is_user_in_groups_selected($poster_id);

	if (($introduciator_params['is_include_groups'] && $is_in_group_selected) || (!$introduciator_params['is_include_groups'] && !$is_in_group_selected))
	{	// The user must intruduce himself
		// May be it is one of the users into ignored list
		$ret = in_array(utf8_strtolower($poster_name),explode("\n", utf8_strtolower($introduciator_params['ignored_users'])));
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
 * @param $auth User permissions
 * @return None.
 */
function introduciator_verify_posting($user,$mode,$forum_id,$post_id,$auth)
{
	global $phpbb_root_path, $phpEx, $template;

	$poster_id = $user->data['user_id'];
	if ($poster_id != ANONYMOUS && $auth->acl_get('u_'))
	{	// User is logged and have user authorization
		$params = introduciator_getparams();

		if ($params['is_enabled'])
		{	// MOD is enabled and the user is not ignored, it can do all he wants
			// Force forum id because it be moved while user delete the message
			global $db;

			$is_user_ignored = is_user_ignored($poster_id,$user->data['username'],$params);
			
			if ($mode == 'delete' || !$is_user_ignored)
			{
				$sql = 'SELECT forum_id
						FROM ' . POSTS_TABLE . '
						WHERE post_id = ' . $post_id;
				$result = $db->sql_query($sql);
				$f_id = (int) $db->sql_fetchfield('forum_id');
				$db->sql_freeresult($result);

				// Take new forum id
				$forum_id = (!$f_id) ? $forum_id : $f_id;

				if (!$is_user_ignored && !is_user_has_post_into_introduciator_topic($params['fk_forum_id'],$poster_id))
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
				else if (!$is_user_ignored && $forum_id == $params['fk_forum_id'] && $mode == 'post')
				{	// User try to create more than one introduce post
					$user->setup('mods/introduciator'); // Add lang
					$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'];
					$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id) . '">', '</a>');
					trigger_error($message,E_USER_NOTICE);
				}
				else if ($mode == 'delete' && !empty($post_id))
				{	// Check if the user don't try to remove the first message of it's OWN introduce
					// Don't care about $is_user_ignored => Administrator / Moderator cannot delete first posts of presentation
					// else he needs to delete all the topic
					if ($params['fk_forum_id'] == $forum_id
						&& $user->data['is_registered']
						&& $auth->acl_gets('f_delete', 'm_delete', $forum_id))
					{	// This post is into the introduce forum
						// Find the topic identifier
						$sql = 'SELECT topic_id,poster_id
								FROM ' . POSTS_TABLE . '
								WHERE post_id = ' . $post_id;

						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						$topic_id = $row['topic_id'];
						$first_poster_id = $row['poster_id'];	// <-- $poster_id could be <> from current user id
																// It's this case when moderator try to delete post of another user
						if (!empty($topic_id) && !empty($first_poster_id))
						{	// Check if this post is the first one, ie this is the post that created the Topic
							$sql = 'SELECT topic_first_post_id
									FROM ' . TOPICS_TABLE . '
									WHERE topic_id = ' . $topic_id;
							$result = $db->sql_query($sql);
							$topic_first_post_id = (int) $db->sql_fetchfield('topic_first_post_id');
							$db->sql_freeresult($result);
							if (!empty($topic_first_post_id) && $topic_first_post_id == $post_id)
							{	// The user try to delete the first post of one intruduce topic : may be not allowed
								// To finish, the $first_poster_id MUST BE not ignored
								if (!is_user_ignored($first_poster_id,$user->data['username'],$params))
								{
									$user->setup('mods/introduciator'); // Add lang
									$message = $user->lang[$first_poster_id == $poster_id ? 'INTRODUCIATOR_MOD_DELETE_INTRODUCE_MY_FIRST_POST' : 'INTRODUCIATOR_MOD_DELETE_INTRODUCE_FIRST_POST'];
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
			}
		}
	}
}

?>