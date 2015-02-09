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
if (!defined('INTRODUCIATOR_CURRENT_VERSION'))
{
	include($phpbb_root_path . 'includes/functions_introduciator.' . $phpEx);
}

if (!function_exists('set_config'))
{
	include($phpbb_root_path . 'includes/functions.' . $phpEx);
}

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
	var $file_version_check		= 'introduciator_version.txt';

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
					$template->assign_var('S_INTRODUCIATOR_VERSIONCHECK_FAIL',true);
				}
				else
				{
					$latest_version_info = explode("\n", $latest_version_info);
					$version_check = $this->get_update_information('url-', $latest_version_info);
					$infos = $this->get_update_information('info-', $latest_version_info);

					$template->assign_vars(array(
						'S_INTRODUCIATOR_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $config['introduciator_mod_version'], '<='),
						'S_INTRODUCIATOR_VERSIONCHECK_URL_FOUND'=> $version_check[1],
						'U_INTRODUCIATOR_VERSIONCHECK'			=> $version_check[0],
						'L_INTRODUCIATOR_UPDATE_VERSION'		=> trim($latest_version_info[0]),
						'L_INTRODUCIATOR_UPDATE_FILENAME'		=> trim(sizeof($latest_version_info) < 3 ? '' : $latest_version_info[2]),
						'U_INTRODUCIATOR_UPDATE_URL'			=> trim(sizeof($latest_version_info) < 4 ? '' : $latest_version_info[3]),
						'L_INTRODUCIATOR_UPDATE_INFORMATION'	=> $infos[0],
					));
				}

				$template->assign_vars(array(
					// Display general page content into ACP .MOD tab
					'S_INTRODUCIATOR_GENERAL_PAGES'			=> true,

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
				global $db, $phpbb_root_path; // Database, Root path
				$this->page_title = 'INTRODUCIATOR_CONFIGURATION';

				// Display configuration page content into ACP .MOD tab
				$template->assign_var('S_CONFIGURATION_PAGES',true);

				// If no action, display configuration
				if (empty($action))
				{	// no action or update current
					$dp_data = array();
	
					$params = introduciator_getparams();
					$template->assign_vars(array(
						'INTRODUCIATOR_MOD_ACTIVATED'							=> $params['introduciator_allow'],
						'INTRODUCIATOR_CHECK_DELETE_FIRST_POST_ACTIVATED'		=> $params['is_check_delete_first_post'],
						'INTRODUCIATOR_DISPLAY_EXPLANATION_ENABLED'				=> $params['is_explanation_enabled'],
						'INTRODUCIATOR_USE_PERMISSIONS'							=> $params['is_use_permissions'],
						'INTRODUCIATOR_INCLUDE_GROUPS_SELECTED'					=> $params['is_include_groups'],
						'INTRODUCIATOR_ITEM_IGNORED_USERS'						=> $params['ignored_users'],
						'INTRODUCIATOR_EXPLANATION_MESSAGE_TITLE'				=> $params['explanation_message_title'],
						'INTRODUCIATOR_EXPLANATION_MESSAGE_TEXT'				=> $params['explanation_message_text'],
						'INTRODUCIATOR_EXPLANATION_IS_DISPLAY_RULES_ENABLED'	=> $params['is_explanation_display_rules'],
						'INTRODUCIATOR_EXPLANATION_MESSAGE_RULES_TITLE'			=> $params['explanation_message_rules_title'],
						'INTRODUCIATOR_EXPLANATION_MESSAGE_RULES_TEXT'			=> $params['explanation_message_rules_text'],
						'U_ACTION'												=> $this->u_action,
					));

					// Add all forums
					$this->add_all_forums($params['fk_forum_id'], 0, 0);

					// Add all groups
					$this->add_all_groups();

					$s_hidden_fields = build_hidden_fields(array(
							'action'				=> 'update',					// Action
						));

					$template->assign_var('S_HIDDEN_FIELDS',$s_hidden_fields);
				}
				else
				{	// Action !
					switch ($action)
					{
						case 'update' :
							// User has request an update : write it into database
							// Update Database
							$is_enabled								= request_var('mod_activated', false);
							$is_check_delete_first_post_activated	= request_var('check_delete_first_post_activated', false);
							$fk_forum_id							= request_var('forum_choice', 0);
							$is_explanation_enabled					= request_var('display_explanation', false);
							$is_use_permissions						= request_var('is_use_permissions', true);
							$is_include_groups						= request_var('include_groups', true);
							$groups									= request_var('groups_choices', array('' => 0)); // Array of IDs of selected groups
							$ignored_users							= substr(utf8_normalize_nfc(request_var('ignored_users', '')), 0, 255);
							$explanation_message_title				= substr(utf8_normalize_nfc(request_var('explanation_message_title', '', true)), 0, 255);
							$explanation_message_text				= substr(utf8_normalize_nfc(request_var('explanation_message_text', '', true)), 0, 255);
							$explanation_display_rules_enabled		= request_var('explanation_display_rules_enabled', false);
							$explanation_message_rules_title		= substr(utf8_normalize_nfc(request_var('explanation_message_rules_title', '', true)), 0, 255);
							$explanation_message_rules_text			= substr(utf8_normalize_nfc(request_var('explanation_message_rules_text', '', true)), 0, 255);

							// Verify message rules text
							$explanation_message_rules_text_new_uid = $explanation_message_rules_text_new_bitfield = $explanation_message_rules_text_bbcode_options = '';
							$explanation_message_rules_text_verify = $explanation_message_rules_text;
		
							replace_all_by(
								array(
									&$explanation_message_rules_text_verify,
								),
								array(
									'%forum_url%'	=> "http://www.dummy.com/aghxkfps.php", // Make link work
									'%forum_post%'	=> "http://www.dummy.com/aghxkfps.php", // Make link work
								)
							);
							$texts_errors = generate_text_for_storage($explanation_message_rules_text_verify, $explanation_message_rules_text_new_uid, $explanation_message_rules_text_new_bitfield, $explanation_message_rules_text_bbcode_options, true, true, true);

							if (sizeof($texts_errors))
							{	// Errors occured, show them to the user.
								trigger_error(implode('<br>', $errors) . adm_back_link($this->u_action, E_USER_WARNING));
							}

							if ($is_enabled && $fk_forum_id === 0)
							{
								trigger_error($user->lang['INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'] . adm_back_link($this->u_action), E_USER_WARNING);
							}

							set_config('introduciator_allow', $is_enabled ? '1' : '0'); // Set the activation MOD config
							set_config('introduciator_is_check_delete_first_post', $is_check_delete_first_post_activated ? '1' : '0');
							set_config('introduciator_fk_forum_id', $fk_forum_id);
							set_config('introduciator_is_explanation_enabled', $is_explanation_enabled ? '1' : '0');
							set_config('introduciator_is_use_permissions', $is_use_permissions ? '1' : '0');
							set_config('introduciator_is_include_groups', $is_include_groups ? '1' : '0');
							set_config('introduciator_ignored_users', $ignored_users);
							set_config('introduciator_explanation_message_title', $explanation_message_title);
							set_config('introduciator_explanation_message_text', $explanation_message_text);
							set_config('introduciator_is_explanation_display_rules', $explanation_display_rules_enabled ? '1' : '0');
							set_config('introduciator_explanation_message_rules_title', $explanation_message_rules_title);
							set_config('introduciator_explanation_message_rules_text', $explanation_message_rules_text);

							// Update INTRODUCIATOR_GROUPS_TABLE
							// 1> Remove all entries
							$sql = 'DELETE FROM ' . INTRODUCIATOR_GROUPS_TABLE;
							$db->sql_query($sql);

							// 2> Add all entries
							$values = array();
							foreach ($groups as &$group)
							{	// Create elements to add by row
								$values[] = array('fk_group' => (int) $group);
							}
							// Create and execute SQL request
							$db->sql_multi_insert(INTRODUCIATOR_GROUPS_TABLE, $values);

							add_log('admin', 'LOG_INTRODUCIATOR_UPDATED' , 'INTRODUCIATOR_CONFIGURATION');
							trigger_error($user->lang['INTRODUCIATOR_CP_UPDATED'] . adm_back_link($this->u_action));
							break;

						default:
							trigger_error($user->lang['NO_MODE'] . adm_back_link($this->u_action));
							break;
				} // End of switch Action
			}
		}
	}

	function add_all_forums($fk_selected_forum_id, $id_parent, $level)
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
		$sql = 'SELECT forum_name, forum_id, forum_desc, forum_type
				FROM ' . FORUMS_TABLE . '
				WHERE parent_id = ' . (int) $id_parent;

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('forums', array(
				'FORUM_NAME'	=> str_repeat("&nbsp;", 4 * $level) . $row['forum_name'],
				'FORUM_ID'		=> (int) $row['forum_id'],
				'SELECTED'		=> ($fk_selected_forum_id == $row['forum_id']),
				'CAN_SELECT'	=> ((int) $row['forum_type']) == FORUM_POST,
				'TOOLTIP'		=> $row['forum_desc'],
			));
			$this->add_all_forums($fk_selected_forum_id, $row['forum_id'], $level + 1);
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

		$sql = 'SELECT group_id, group_desc
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
	 * @param int $ttl Cache version information for $ttl seconds. Defaults to 86400 (24 hours).
	 *
	 * @return string | false Version info on success, false on failure.
	 */
	function obtain_latest_version_info($force_update = false, $ttl = 86400)
	{
		global $cache;

		$info = $cache->get('introduciator_version_check');

		if ($info === false || $force_update)
		{
			$errstr = '';
			$errno = 0;

			$info = get_remote_file($this->url_version_check, $this->folder_version_check, $this->file_version_check, $errstr, $errno);

			if ($info === false)
			{
				$cache->destroy('introduciator_version_check');
				return false;
			}

			$cache->put('introduciator_version_check', $info, $ttl);
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
	 * @return An array with:
	 *   [0] The string into the correct language. English if the current language is not found. Error message if default language was not found
	 *   [1] Indicate if the string (default or not) was found or not (true / false).
	 */
	function get_update_information($tag, $latest_version_info)
	{
		global $tag_and_lang, $tag_and_lang_en, $user, $tag_len;

		$information = $user->lang['INTRODUCIATOR_NO_UPDATE_INFO_FOUND'];
		$found = false;

		$tag_and_lang = '[' . $tag . $user->lang['USER_LANG'] . ']';
		$tag_and_lang_en =  '[' . $tag . 'en]';
		$tag_len = strlen($tag_and_lang_en);

		for ($index = 4;$index < sizeof($latest_version_info);++$index)
		{
			if (strlen($latest_version_info[$index]) > $tag_len)
			{
				$line_lang = substr($latest_version_info[$index], 0, $tag_len);
				if ($line_lang === $tag_and_lang)
				{
					$information = substr($latest_version_info[$index], $tag_len, strlen($latest_version_info[$index]) - $tag_len);
					$found = true;
					break; // Found, quit the for
				}
				else if ($line_lang === $tag_and_lang_en)
				{	// English by default if found
					$information = substr($latest_version_info[$index], $tag_len, strlen($latest_version_info[$index]) - $tag_len);
					$found = true;
				}
			}
		}

		return array(
			str_replace('\\n', '<br/>', $information),
			$found,
		);
	}
}
?>