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

global $phpbb_root_path, $phpEx;
require_once($phpbb_root_path . 'includes/functions_introduciator.' . $phpEx);

/**
* @package acp
*/
class acp_introduciator
{
	// URL of web site where download the latest version file info
	var $url_version_check		= 'feneck91.free.fr';
	// Folder in web site where download the latest version file info
	var $folder_version_check	= '/phpbb';
	// File name to download the latest version file info
	var $file_version_check		= 'test_introduciator_version.txt';

	// Action
	var $u_action;

	function main($id, $mode)
	{
		global $template, $user, $phpEx, $config;

		$user->add_lang('mods/info_acp_introduciator');
		$this->tpl_name = 'acp_introduciator'; // Template file : adm/style/introduciator/acp_introduciator.htm
		$this->page_title = $user->lang['ACP_INTRODUCIATOR_MOD']; // Page Title

		// Add a secret token to the form
		// This functions adds a secret token to any form, a token which should be checked after
		// submission with the check_form_key function to ensure that the received data is the same as the submitted.
		$form_key = 'acp_introduciator';
		add_form_key($form_key);

xdebug_break();
		$action	= request_var('action', '');

		switch ($mode)
		{
			case 'general':
				global $phpbb_admin_path;

				$this->page_title = 'INTRODUCIATOR_GENERAL';
				// Check if a new version of this MOD is available
				$latest_version_info = $this->obtain_latest_version_info(request_var('introduciator_versioncheck_force', false));

				if ($latest_version_info === false || !function_exists('phpbb_version_compare'))
				{
					$template->assign_vars(array(
						'S_INTRODUCIATOR_VERSIONCHECK_FAIL'	=> true,
					));
				}
				else
				{
					$latest_version_info = explode("\n", $latest_version_info);

					$template->assign_vars(array(
						'S_INTRODUCIATOR_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $config['introduciator_mod_version'], '<='),
						'U_INTRODUCIATOR_VERSIONCHECK'			=> $this->get_update_information('url-',$latest_version_info),
						'L_INTRODUCIATOR_UPDATE_VERSION'		=> trim($latest_version_info[0]),
						'L_INTRODUCIATOR_UPDATE_FILENAME'		=> htmlspecialchars(trim($latest_version_info[2])),
						'U_INTRODUCIATOR_UPDATE_URL'			=> htmlspecialchars(trim($latest_version_info[3])),
						'L_INTRODUCIATOR_UPDATE_INFORMATION'	=> $this->get_update_information('info-',$latest_version_info),
					));
				}

				$template->assign_vars(array(
					// Display general page content into ACP .MOD tab
					'S_GENERAL_PAGES'						=> true,

					// Current version of this MOD
					'INTRODUCIATOR_VERSION'					=> $config['introduciator_mod_version'],
					// Install date of this MOD
					'INTRODUCIATOR_INSTALL_DATE'			=> $user->format_date($config['introduciator_install_date']),

					// Check force URL
					// i is the ID of this MOD (introduciator) / mode is the sub item
					'U_INTRODUCIATOR_VERSIONCHECK_FORCE'	=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=introduciator&amp;mode=' . $mode . '&amp;introduciator_versioncheck_force=1'),
					'U_ACTION'								=> $this->u_action,
				));
			break;

			case 'configuration':
				global $db; // Database
				$this->page_title = 'INTRODUCIATOR_CONFIGURATION';

				// Display configuration page
				$template->assign_vars(array(
					// Display Configuration page content into ACP .MOD tab
					'S_CONFIGURATION_PAGES'	=> true,
				));

				// If no action, display configuration
				if (empty($action))
				{	// no action or update current
					$dp_data = array();

					$params = introduciator_getparams();

					$template->assign_vars(array(
						'MOD_ACTIVATED'							=> $config['allow_introduciator'],
						'CHECK_DELETE_FIRST_POST_ACTIVATED'		=> $params['is_check_delete_first_post_enabled'],
						'DISPLAY_EXPLANATION_ENABLED'			=> $params['is_explanation_enabled'],
						'USE_PERMISSIONS'						=> $params['is_use_permissions'],
						'INCLUDE_GROUPS_SELECTED'				=> $params['is_include_groups'],
						'ITEM_IGNORED_USERS'					=> $params['ignored_users'],
						'EXPLANATION_MESSAGE_TITLE'				=> $params['explanation_message_title'],
						'EXPLANATION_MESSAGE_TEXT'				=> $params['explanation_message_text'],
						'EXPLANATION_IS_DISPLAY_RULES_ENABLED'	=> $params['explanation_display_rules_enabled'],
						'EXPLANATION_MESSAGE_RULES_TITLE'		=> $params['explanation_message_rules_title'],
						'EXPLANATION_MESSAGE_RULES_TEXT'		=> $params['explanation_message_rules_text'],
						'U_ACTION'								=> $this->u_action,
					));

					// Add all forums
					$this->add_all_forums($params['fk_forum_id'],0,0);

					// Add all groups
					$this->add_all_groups();

					$s_hidden_fields = build_hidden_fields(array(
							'action'		=> 'update',					// Action
							'id'			=> $params['introduciator_id'],	// Id of row for hident input named "id"
						));

					$template->assign_vars(array(
						'S_HIDDEN_FIELDS' => $s_hidden_fields,
					));
				}
				else
				{	// Action !
					switch ($action)
					{
						case 'update' :
							// User has request an update : write it into database
							// Update Database
							$is_enabled								= (bool) request_var('mod_activated', false);
							$is_check_delete_first_post_activated	= (bool) request_var('check_delete_first_post_activated', false);
							$fk_forum_id							= (int)  request_var('forum_choice', 0);
							$is_explanation_enabled					= (bool) request_var('display_explanation', false);
							$is_use_permissions						= (bool) request_var('is_use_permissions', false);
							$is_include_groups						= (bool) request_var('include_groups', false);
							$groups									= request_var('groups_choices', array('' => 0)); // Array of IDs of selected groups
							$ignored_users							= utf8_normalize_nfc(request_var('ignored_users', ''));
							$explanation_message_title				= utf8_normalize_nfc(request_var('explanation_message_title', '', true));
							$explanation_message_text				= utf8_normalize_nfc(request_var('explanation_message_text', '', true));
							$explanation_display_rules_enabled		= (bool) request_var('explanation_display_rules_enabled', false);
							$explanation_message_rules_title		= utf8_normalize_nfc(request_var('explanation_message_rules_title', '', true));
							$explanation_message_rules_text			= utf8_normalize_nfc(request_var('explanation_message_rules_text', '', true));

							if ($is_enabled && $fk_forum_id === 0)
							{
								trigger_error($user->lang['INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'] . adm_back_link($this->u_action), E_USER_WARNING);
							}
							$sql_ary = array(
								'is_check_delete_first_post_enabled'	=> $is_check_delete_first_post_activated,
								'fk_forum_id'							=> $fk_forum_id,
								'is_explanation_enabled'				=> $is_explanation_enabled,
								'is_use_permissions'					=> $is_use_permissions,
								'is_include_groups'						=> $is_include_groups,
								'ignored_users'							=> $ignored_users,
								'explanation_message_title'				=> $explanation_message_title,
								'explanation_message_text'				=> $explanation_message_text,
								'explanation_display_rules_enabled'		=> $explanation_display_rules_enabled,
								'explanation_message_rules_title'		=> $explanation_message_rules_title,
								'explanation_message_rules_text'		=> $explanation_message_rules_text,
							);

							// Set the activation MOD config
							set_config('allow_introduciator', $is_enabled ? 1 : 0);

							// Update INTRODUCIATOR_CONFIG_TABLE
							$sql = 'UPDATE ' . INTRODUCIATOR_CONFIG_TABLE . '
									SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
									WHERE introduciator_id = ' . (int) request_var('id', 0);
							$db->sql_query($sql);

							// Update INTRODUCIATOR_GROUPS_TABLE
							// 1> Remove all entries
							$sql = 'TRUNCATE TABLE ' . INTRODUCIATOR_GROUPS_TABLE;
							$db->sql_query($sql);

							// 2> Add all entries
							$values = array();
							foreach ($groups as &$group)
							{	// Create elements to add by row
								$values[] = array('fk_group' => (int) $group);
							}
							// Create and execute SQL request
							$db->sql_multi_insert(INTRODUCIATOR_GROUPS_TABLE, $values);

							add_log('admin', 'LOG_INTRODUCIATOR_UPDATED' , $user->lang['INTRODUCIATOR_CONFIGURATION']);
							trigger_error($user->lang['INTRODUCIATOR_CP_UPDATED'] . adm_back_link($this->u_action));
							break;

						default:
							trigger_error($user->lang['NO_MODE'] . adm_back_link($this->u_action));
							break;
				} // End of switch Action
			}
		}
	}

	function add_all_forums($fk_selected_forum_id,$id_parent,$level)
	{
		global $db, $template, $user;

		if ($id_parent === 0)
		{	// Add deactivation item
			$template->assign_block_vars('forums', array(
				'FORUM_NAME'	=> $user->lang['INTRODUCIATOR_NO_FORUM_CHOICE'],
				'FORUM_ID'		=> (int) 0,
				'SELECTED'		=> ($fk_selected_forum_id === 0),
				'CAN_SELECT'	=> true,
				'TOOLTIP'		=> $user->lang['INTRODUCIATOR_NO_FORUM_CHOICE_TOOLTIP'],
				));
		}

		// Add all forums
		$sql = 'SELECT forum_name,forum_id,forum_desc,forum_type
				FROM ' . FORUMS_TABLE . '
				WHERE parent_id = ' . (int) $id_parent;

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('forums', array(
				'FORUM_NAME'	=> str_repeat("&nbsp;",4 * $level) . $row['forum_name'],
				'FORUM_ID'		=> (int) $row['forum_id'],
				'SELECTED'		=> ($fk_selected_forum_id == $row['forum_id']),
				'CAN_SELECT'	=> ((int) $row['forum_type']) == FORUM_POST,
				'TOOLTIP'		=> $row['forum_desc'],
				));
			$this->add_all_forums($fk_selected_forum_id,$row['forum_id'],$level + 1);
		}
		$db->sql_freeresult($result);
	}

	/**
	 * Find all groups to propose it to the user.
	 *
	 * Add all elements into the template.
	 */
	function add_all_groups()
	{
		global $db, $template;

		$sql = 'SELECT group_id,group_desc
			FROM ' . GROUPS_TABLE;

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('group', array(
			'NAME'		=> get_group_name($row['group_id']),
			'ID'		=> (int) $row['group_id'],
			'SELECTED'	=> is_group_selected($row['group_id']),
			'TOOLTIP'	=> $row['group_desc'],
			));
		}
		$db->sql_freeresult($result);
	}

	/**
	 * Obtains the latest version information.
	 *
	 * @param bool $force_update Ignores cached data. Defaults to false.
	 * @param bool $warn_fail Trigger a warning if obtaining the latest version information fails. Defaults to false.
	 * @param int $ttl Cache version information for $ttl seconds. Defaults to 86400 (24 hours).
	 *
	 * @return string | false Version info on success, false on failure.
	 */
	function obtain_latest_version_info($force_update = false, $warn_fail = false, $ttl = 86400)
	{
		global $cache;

		$info = "";
		$info = $cache->get('introduciatorversioncheck');

		if ($info === false || $force_update)
		{
			$errstr = '';
			$errno = 0;

			$info = get_remote_file($this->url_version_check, $this->folder_version_check, $this->file_version_check, $errstr, $errno);

			if ($info === false)
			{
				$cache->destroy('introduciatorversioncheck');
				if ($warn_fail)
				{
					trigger_error($errstr, E_USER_WARNING);
				}
				return false;
			}

			$cache->put('introduciatorversioncheck', $info, $ttl);
		}

		return $info;
	}

	/**
	 * Get the update information string from text loaded from update web site.
	 *
	 * The language is written at the beginning of each lines, like [en] ou [fr].
	 *
	 * @param string $tag the tag to found. Searching [$tag{language name}] at the beginning of the line.
	 * @param array $latest_version_info Array of string, the informations begins at line 2.
	 * @return The string into the correct language. English if the current language is not found.
	 */
	function get_update_information($tag,$latest_version_info)
	{
		global $tag_and_lang,$tag_and_lang_en,$user,$tag_len;

		$information = $user->lang['INTRODUCIATOR_NO_UPDATE_INFO_FOUND'];

		$tag_and_lang = '[' . $tag . $user->lang['USER_LANG'] . ']';
		$tag_and_lang_en =  '[' . $tag . 'en]';
		$tag_len = strlen($tag_and_lang_en);

		for ($index = 4;$index < sizeof($latest_version_info);++$index)
		{
			if (strlen($latest_version_info[$index]) > $tag_len)
			{
				$line_lang = substr($latest_version_info[$index],0,$tag_len);
				if ($line_lang === $tag_and_lang)
				{
					$information = substr($latest_version_info[$index],$tag_len,strlen($latest_version_info[$index]) - $tag_len);
					break; // Found, quit the for
				}
				else if ($line_lang === $tag_and_lang_en)
				{	// English by default if found
					$information = substr($latest_version_info[$index],$tag_len,strlen($latest_version_info[$index]) - $tag_len);
				}
			}
		}

		return str_replace('\\n','<br/>',htmlspecialchars($information));
	}
}
?>