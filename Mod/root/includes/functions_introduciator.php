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
 * @param type $forum_id Forum's ID.
 * @param type $user_id User's ID.
 * @return true if the user already post at least one message into this forum, false else.
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
 * @param $user_id User identifier into database.
 * @return true if one of the user's group has been selected into configuration, false else.
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
 * @return The introduciator parameters.
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
 * @param type $poster_id User's ID
 * @param type $poster_name User's name.
 * @param type $introduciator_params Introduce MOD parameters.
 * @return true if the user is ignored, false else.
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
 * If not allowed, it redirect the current page to the introduce forum or the explanation page.
 *
 * @param $poster_id The poster id
 * @param $mode posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
 * @param $forum_id Forum identifier where the user try to post.
 * $auth User permissions.
 *
 * @return None.
 */
function introduciator_verify_posting($user,$mode,$forum_id,$auth)
{
	global $phpbb_root_path, $phpEx, $template;

	$poster_id = $user->data['user_id'];
	if ($poster_id != ANONYMOUS && $auth->acl_get('u_'))
	{	// User is logged and have user authorization
		$params = introduciator_getparams();

		if ($params['is_enabled'])
		{	// MOD is enabled
			if (!is_user_has_post_into_introduciator_topic($params['fk_forum_id'],$poster_id))
			{	// No post into the introduce topic
				if ((in_array($mode,array('reply', 'quote')) || ($mode == 'post' && $forum_id != $params['fk_forum_id'])))
				{
					if (!is_user_ignored($poster_id,$user->data['username'],$params))
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
			}
			else if ($forum_id == $params['fk_forum_id'] && $mode == 'post')
			{	// User try to create more than one introduce post
				if (!is_user_ignored($poster_id,$user->data['username'],$params))
				{	// Post more than once ! and not into the ignored list
					$user->setup('mods/introduciator'); // Add lang
					$message = $user->lang['INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'];
					$message .= '<br /><br />' . sprintf($user->lang['RETURN_FORUM'], '<a href="' . append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $forum_id) . '">', '</a>');
					trigger_error($message,E_USER_NOTICE);
				}
			}
		}
	}
}

?>