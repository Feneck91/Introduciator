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

/**
* @package acp
*/
class acp_introduciator
{
	// URL of web site where download the latest version file info
	private $url_version_check		= 'feneck91.free.fr';
	// Folder in web site where download the latest version file info
	private $folder_version_check	= '/phpbb';
	// File name to download the latest version file info
	private $file_version_check		= 'introduciator_version.txt';
	// Action
	var $u_action;

	function main($id, $mode)
	{
		global $template, $user, $phpbb_root_path, $phpEx, $config;

		include($phpbb_root_path . 'includes/functions_introduciator.' . $phpEx);
		$user->add_lang('mods/info_acp_introduciator');

		$this->tpl_name = 'acp_introduciator'; // Template file : adm/style/introduciator/acp_introduciator.htm
		$this->page_title = $user->lang['ACP_INTRODUCIATOR_MOD']; // Page Title
		// Add a secret token to the form
		// This functions adds a secret token to any form, a token which should be checked after
		// submission with the check_form_key function to ensure that the received data is the same as the submitted.
		$form_key = 'acp_introduciator';
		add_form_key($form_key);

		$submit = (isset($_POST['submit'])) ? true : false;
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
						'L_VERSIONCHECK_FAIL'				=> $user->lang['VERSIONCHECK_FAIL'],
					));
				}
				else
				{
					$latest_version_info = explode("\n", $latest_version_info);

					$template->assign_vars(array(
						'S_INTRODUCIATOR_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $config['introduciator_mod_version'], '<='),
						'U_INTRODUCIATOR_VERSIONCHECK'			=> $latest_version_info[1],
					));
				}

				$template->assign_vars(array(
					// Display general page content into ACP .MOD tab
					'S_GENERAL_PAGES'						=> $mode,

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

				// Is Add action ?
				$action = request_var('action', false);
				$introduciator_id = 0; // 0 for new, else it contains the ID

				// Display configuration page
				$template->assign_vars(array(
					// Display Configuration page content into ACP .MOD tab
					'S_CONFIGURATION_PAGES'	=> $mode,
				));

				// If no action, display configuration
				if ($action === false)
				{	// no action or update current
					$dp_data = array();
					$s_hidden_fields = array();

					$params = introduciator_getparams();

					$template->assign_vars(array(
						'S_HIDDEN_FIELDS'						=> $s_hidden_fields,
						'MOD_ACTIVATED'							=> $params['is_enabled'],
						'CHECK_DELETE_FIRST_POST_ACTIVATED'		=> $params['is_check_delete_first_post_enabled'],
						'DISPLAY_EXPLANATION_ENABLED'			=> $params['is_explanation_enabled'],
						'EXPLANATION_MESSAGE_TITLE'				=> $params['explanation_message_title'],
						'EXPLANATION_MESSAGE_TEXT'				=> $params['explanation_message_text'],
						'EXPLANATION_IS_DISPLAY_RULES_ENABLED'	=> $params['explanation_display_rules_enabled'],
						'EXPLANATION_MESSAGE_RULES_TITLE'		=> $params['explanation_message_rules_title'],
						'EXPLANATION_MESSAGE_RULES_TEXT'		=> $params['explanation_message_rules_text'],
						'U_ACTION'								=> $this->u_action,
					));

					// Add all forums
					$this->add_all_forums($params['fk_forum_id'],0,0);

					$s_hidden_fields = build_hidden_fields(array(
							'forum_id'		=> $params['fk_forum_id'],		// Selected forum
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
							$is_enabled								= (request_var('mod_activated', 0) != 0);
							$is_check_delete_first_post_activated	= (request_var('check_delete_first_post_activated', 0) != 0);
							$fk_forum_id							= (int) request_var('forum_choice', 0);
							$is_explanation_enabled					= (request_var('display_explanation', 0) != 0);
							$explanation_message_title				= utf8_normalize_nfc(request_var('explanation_message_title', '', true));
							$explanation_message_text				= utf8_normalize_nfc(request_var('explanation_message_text', '', true));
							$explanation_display_rules_enabled		= (request_var('explanation_display_rules_enabled', 0) != 0);
							$explanation_message_rules_title		= utf8_normalize_nfc(request_var('explanation_message_rules_title', '', true));
							$explanation_message_rules_text			= utf8_normalize_nfc(request_var('explanation_message_rules_text', '', true));

							if ($is_enabled && $fk_forum_id === 0)
							{
								trigger_error($user->lang['INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'] . adm_back_link($this->u_action), E_USER_WARNING);
							}
							$sql_ary = array(
								'is_enabled'							=> $is_enabled,
								'is_check_delete_first_post_enabled'	=> $is_check_delete_first_post_activated,
								'fk_forum_id'							=> $fk_forum_id,
								'is_explanation_enabled'				=> $is_explanation_enabled,
								'explanation_message_title'				=> $explanation_message_title,
								'explanation_message_text'				=> $explanation_message_text,
								'explanation_display_rules_enabled'		=> $explanation_display_rules_enabled,
								'explanation_message_rules_title'		=> $explanation_message_rules_title,
								'explanation_message_rules_text'		=> $explanation_message_rules_text,
							);

							// Update INTRODUCIATOR_CONFIG_TABLE
							$sql = 'UPDATE ' . INTRODUCIATOR_CONFIG_TABLE . '
									SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
									WHERE introduciator_id = ' . (int) request_var('id', 0);
							$db->sql_query($sql);

							add_log('admin', 'LOG_INTRODUCIATOR_UPDATED' , $user->lang['INTRODUCIATOR_CONFIGURATION']);
							trigger_error($user->lang['INTRODUCIATOR_CP_UPDATED'] . adm_back_link($this->u_action));
							break;

						default:
							trigger_error('NO_MODE', E_USER_ERROR);
							break;
				} // End of switch Action
			}
		}
	}

	function add_all_forums($fk_selected_forum_id,$id_parent,$level)
	{
		global $db, $template, $user;

		if ($id_parent == 0)
		{	// Add deactivation item
			$template->assign_block_vars('forums', array(
			'FORUM_NAME'	=> $user->lang['INTRODUCIATOR_NO_FORUM_CHOICE'],
			'FORUM_ID'		=> (int) 0,
			'SELECTED'		=> ($fk_selected_forum_id == 0),
			'TOOLTIP'		=> '',
			));
		}

		// Add all forums
		$sql = 'SELECT forum_name,forum_id,forum_desc
				FROM ' . FORUMS_TABLE . '
				WHERE parent_id = ' . $id_parent;

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('forums', array(
			'FORUM_NAME'	=> str_repeat("&nbsp;",4 * $level) . $row['forum_name'],
			'FORUM_ID'		=> (int) $row['forum_id'],
			'SELECTED'		=> ($fk_selected_forum_id == $row['forum_id']),
			'TOOLTIP'		=> $row['forum_desc'],
			));
			$this->add_all_forums($fk_selected_forum_id,$row['forum_id'],$level + 1);
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
}
?>