<?php
/**
*
* @package Diary MOD
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
class acp_diary
{
	// URL of web site where download the latest version file info
	private $url_version_check		= 'feneck91.free.fr';
	// Folder in web site where download the latest version file info
	private $folder_version_check	= '/phpbb';
	// File name to download the latest version file info
	private $file_version_check		= 'diary_version.txt';
	// Action
	var $u_action;

	function main($id, $mode)
	{
		global $template;			// Page template
		global $user;				// User information
		global $phpbb_root_path;	// Php bb root path
		global $phpEx;				// php Extension
		global $config;				// Configuration

		include($phpbb_root_path . 'includes/functions_diary.' . $phpEx);

		$this->tpl_name = 'acp_diary'; // Template file : adm/style/diary/acp_diary.htm
		$this->page_title = $user->lang['ACP_DIARY_MOD']; // Page Title
		// Add a secret token to the form
		// This functions adds a secret token to any form, a token which should be checked after
		// submission with the check_form_key function to ensure that the received data is the same as the submitted.
		$form_key = 'acp_diary';
		add_form_key($form_key);

		$submit = (isset($_POST['submit'])) ? true : false;
		$action	= request_var('action', '');

		switch ($mode)
		{
			case 'general':
			{
				global $phpbb_admin_path, $auth;

				$this->page_title = 'DIARY_GENERAL';
				// Check if a new version of this MOD is available
				$latest_version_info = $this->obtain_latest_version_info(request_var('diary_versioncheck_force', false));

				if ($latest_version_info === false || !function_exists('phpbb_version_compare'))
				{
					$template->assign_vars(array(
						'S_DIARY_VERSIONCHECK_FAIL'		=> true,
						'L_VERSIONCHECK_FAIL'			=> sprintf($user->lang['VERSIONCHECK_FAIL'], $latest_version_info),
					));
				}
				else
				{
					$latest_version_info = explode("\n", $latest_version_info);

					$template->assign_vars(array(
						'S_DIARY_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $config['diary_mod_version'], '<='),
						'U_DIARY_VERSIONCHECK'			=> $latest_version_info[1],
					));
				}

				$template->assign_vars(array(
					// Display general page content into ACP .MOD tab
					'S_GENERAL_PAGES'				=> $mode,

					// Current version of this MOD
					'DIARY_VERSION'					=> $config['diary_mod_version'],
					// Install date of this MOD
					'DIARY_INSTALL_DATE'			=> $user->format_date($config['diary_install_date']),

					// Check force URL
					// i is the ID of this MOD (diary) / mode is the sub item
					'U_DIARY_VERSIONCHECK_FORCE'	=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=diary&amp;mode=' . $mode . '&amp;diary_versioncheck_force=1'),
					'U_ACTION'						=> $this->u_action,
				));

				break;
			}
			case 'configuration':
			{
				global $db; // Database
				$this->page_title = 'DIARY_CONFIGURATION';

				// Is Add action ?
				$addnew = request_var('addnew', false);
				$action = $addnew ? 'addnew' : request_var('action', '');
				$is_edit = ($action ==='edit');
				$diary_id = 0; // 0 for new, else it contains the ID

				// Display configuration page
				$template->assign_vars(array(
					// Display Configuration page content into ACP .MOD tab
					'S_CONFIGURATION_PAGES'	=> $mode,
				));

				// If no action, display diaries list
				if (!$action)
				{
					$sql = sprintf('SELECT * FROM %s ORDER BY left_id',DIARY_ITEMS_TABLE);
					$result = $db->sql_query($sql);

					while ($row = $db->sql_fetchrow($result))
					{
						$row_id = (int) $row['diary_id'];

						$template->assign_block_vars('items', array(
						'NAME'			=> $row['diary_name'],
						// links
						'U_EDIT'			=> $this->u_action . '&amp;action=edit&amp;id=' . $row_id,
						'U_MOVE_UP'			=> $this->u_action . '&amp;action=move_up&amp;id=' . $row_id,
						'U_MOVE_DOWN'		=> $this->u_action . '&amp;action=move_down&amp;id=' . $row_id,
						'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;id=' . $row_id,
						));
					};
					$db->sql_freeresult($result);

					$template->assign_vars(array(
						// Check force URL
						// i is the ID of this MOD (diary) / mode is the sub item
						'U_DIARY_ADD_NEW'	=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=diary&amp;mode=' . $mode . '&amp;action=addnew'),
						'S_EDIT'			=> false,
					));
				}
				else
				{	// Action
					$dp_data = null;
					$s_hidden_fields = null;

					switch ($action)
					{
						case 'move_up':
						case 'move_down':
						{
							if (!$diary_id)
							{
								trigger_error($user->lang['MUST_SELECT_ITEM'] . adm_back_link($this->u_action), E_USER_WARNING);
							}

							$sql = printf("SELECT %s FROM WHERE diary_id = %d",
										  INTRODUCIATOR_ITEM_TABLE,
										  (int) $diary_id);
							$result = $db->sql_query($sql);
							$row = $db->sql_fetchrow($result);
							$db->sql_freeresult($result);

							$move_item_name = $this->move_items_by($row, $action, 1);

							if ($move_item_name !== false )
							{
								add_log('admin', 'LOG_DIARY_ITEM_' . strtoupper($action), $user->lang['LOG_DIARY_CONFIGURATION_ITEM'], $row['diary_name'], $move_item_name);
							}
							break;
						}
						case 'update' :
						{	// User has request an update : write it into database
							$error_msg = null;
							$diary_id  = request_var('id', 0, true);
							$item_name = utf8_normalize_nfc(request_var('item_name', '', true));
							$left_id   = request_var('left_id', 0, true);
							$right_id  = request_var('right_id', 0, true);
							$item_tag  = utf8_normalize_nfc(request_var('item_tag', '', true));
							$item_filter_tags = utf8_normalize_nfc(request_var('item_filter_tags', '', true));
							$forums = request_var('forums_choices[]', 0, true);

							if ($item_name === '')
							{
								$error_msg = $user->lang['ERROR_DIARY_NAME_EMPTY'];
							}
							else if (strlen($item_tag) != 3)
							{
								$error_msg = $user->lang['ERROR_DIARY_ITEM_TAG_INVALID'];
							}

							else
							{
								$right_id = execute_sql_value(printf('SELECT MAX(right_id) AS right_id FROM %s',DIARY_ITEMS_TABLE),'right_id');
								$diary_item['left_id'] = $right_id + 1;
								$diary_item['right_id'] = $right_id + 2;

								$db->sql_query(sprintf('INSERT INTO %s %s',DIARY_ITEMS_TABLE,$db->sql_build_array('INSERT', $diary_item)));
							}

							if ($error_msg !== null)
							{
								$dp_data = array(
									'id'				=> $diary_id,
									'item_name'		=> $item_name,
									'item_tag'			=> $item_tag,
									'filter_tag'		=> $filter_tag,
									'left_id'			=> $item_enable,
									'right_id'			=> $mode,
								);
								// Indicate to web page that current display is EDITION (edit or new one)
								$template->assign_vars(array(
									'S_EDIT_ERROR'		=> true,
									'ITEM_EDIT_ERROR'	=> $error_msg
								));
							}
							else
							{
								$trigger_url = (!$diary_id ? '&amp;action=addnew&amp;back=1' : '&amp;action=edit&amp;back=1&amp;id=') . (int) $diary_id;
								trigger_error($user->lang['ERROR_DIARY_NAME_EMPTY'] . adm_back_link($this->u_action . $trigger_url));
								break;
							}
						}
						// Show the editor
						case 'addnew' :
						case 'edit' :
						{	// Create new Diary
							$s_hidden_fields = array();

							// Indicate to web page that current display is EDITION (edit or new one)
							$template->assign_vars(array(
								'S_EDIT'			=> true,
							));

							if ($dp_data === null)
							{
								if ($is_edit)
								{	// Edit existing item
									// Initiate diary edit item page data array
									$diary_id = (int) request_var('id', 0);
									$sql = sprintf('SELECT * FROM %s WHERE diary_id = %d',DIARY_ITEMS_TABLE,$diary_id);
									$result = $db->sql_query($sql);
									if ($row = $db->sql_fetchrow($result))
									{
										$dp_data = array(
											'id'					=> $row['diary_id'],
											'item_name'				=> $row['diary_name'],
											'left_id'				=> $row['left_id'],
											'right_id'				=> $row['right_id'],
											'item_tag'				=> $row['tag'],
											'item_filter_tags'		=> $row['filter_tag'],
										);
									}
									else
									{
										$db->sql_freeresult($result);
										trigger_error($user->lang['ERROR_NO_DIARY_ID'] . adm_back_link($this->u_action), E_USER_ERROR);
									}
									$db->sql_freeresult($result);
								}
								else
								{	// New item
									// Initiate diary new item page data array
									$dp_data = array(
										'diary_id'					=> 0,	// New item
										'item_name'					=> '',
										'left_id'					=> 0,	// Not set for the moment, compute when creating
										'right_id'					=> 0,	// Not set for the moment, compute when creating
										'item_tag'					=> '',
										'item_filter_tags'			=> ''
									);
								}
							}
							$template->assign_vars(array(
								'ITEM_NAME'					=> $dp_data['item_name'],
								'ITEM_TAG'					=> $dp_data['item_tag'],
								'ITEM_FILTER_TAGS'			=> $dp_data['item_filter_tags'],
							));

							// Add all forums
							$this->add_all_forums(0,0,0);

							$s_hidden_fields = build_hidden_fields(array(
								'id'			=> $diary_id,
								'action'		=> 'update',
								'left_id'		=> $dp_data['left_id'],
								'right_id'		=> $dp_data['right_id'],
							));
							break;
						}
					}
					if ($dp_data != null)
					{

						$template->assign_vars(array(
							'S_HIDDEN_FIELDS' => $s_hidden_fields,
						));
					}
				}
				break;
			}
			case 'events_types':
				$template->assign_vars(array(
					'S_EVENTS_TYPES_PAGES'	=> $mode,	// Display Events Types page content into ACP .MOD tab
				));
				break;
			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}
	}

	function add_all_forums($id_diary,$id_parent,$level)
	{
		global $db;			// Database
		global $template;	// Page template
		global $user;		// User information

		if ($id_parent == 0 && $level == 0)
		{	// Add 'main page' into the forum's list (first one)
			$template->assign_block_vars('forums', array(
			'FORUM_NAME'				=> $user->lang['DIARY_CP_ED_MAIN_PAGE'],
			'FORUM_ID'					=> MAIN_PAGE_FORUM_ID, // MAIN_PAGE_FORUM_ID is Main page, specific case
			'SELECTED'					=> ($id_diary == 0
												// If new diary, select it only if it is the first one
												? !$this->is_at_least_one_diary_exists()
												// else check table to know if it is selected or not
												: is_diary_displayed_into_forum($id_diary,MAIN_PAGE_FORUM_ID)),
			'TOOLTIP'					=> $user->lang['DIARY_CP_ED_MAIN_PAGE_TOOLTIP'],
			));
			$level = $level + 1;
		}

		$sql = sprintf('SELECT forum_name,forum_id,forum_desc FROM %s WHERE parent_id = %d',FORUMS_TABLE,$id_parent);
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('forums', array(
			'FORUM_NAME'				=> str_repeat("&nbsp;",4 * $level) . $row['forum_name'],
			'FORUM_ID'					=> (int) $row['forum_id'],
			'SELECTED'					=> is_diary_displayed_into_forum($id_diary,$row['forum_id']),
			'TOOLTIP'					=> $row['forum_desc'],
			));
			$this->add_all_forums($id_diary,$row['forum_id'],$level + 1);
		}
		$db->sql_freeresult($result);
	}

	/**
	 * Indicate if at least one diary exists or not.
	 *
	 * Used to know if the diary creation is the first one or not. In this case
	 * the first created diary has 'main page' automatically selected.
	 *
	 * @return true if at least one diary exists, false else.
	 */
	function is_at_least_one_diary_exists()
	{
		return is_exists_at_least_once(DIARY_ITEMS_TABLE,NULL);
	}

	/**
	 * Obtains the latest diary_id (primary key) into the ordered list of diaries.
	 *
	 * All diaries are stored into the DIARY_ITEMS_TABLE table, each row have
	 * a previous_id that indicate the primary key (diary_id) of the previous
	 * diary. This help to know the diary order into the forums.
	 *
	 * @return The latest diary primary key if found, 0 if no diary exists.
	 */
	function find_last_diary_id()
	{
		global $db;			// Database

		// First item : has previous_id to 0
		$last_id = 0;

		// Find last diary into the ordered list of diaries
		$sql = sprintf('SELECT diary_id,previous_id FROM %s WHERE previous_id = %d',DIARY_ITEMS_TABLE,$last_id);
		$result = $db->sql_query($sql);
		if ($row = $db->sql_fetchrow($result))
		{	// Get the last item
			$is_displayed_main = false; // Not first item: do not show it into the main page
			do
			{
				$last_id = $row['diary_id'];
				$sql =	sprintf('SELECT diary_id,previous_id FROM %s WHERE previous_id = %d',DIARY_ITEMS_TABLE,$last_id);
 				$result = $db->sql_query($sql);
			}
			while ($row = $db->sql_fetchrow($result));
		}

		return $last_id;
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
		$info = "";

		global $cache;

		$info = $cache->get('diaryversioncheck');

		if ($info === false || $force_update)
		{
			$errstr = '';
			$errno = 0;

			$info = get_remote_file($this->url_version_check, $this->folder_version_check, $this->file_version_check, $errstr, $errno);

			if ($info === false)
			{
				$cache->destroy('diaryversioncheck');
				if ($warn_fail)
				{
					trigger_error($errstr, E_USER_WARNING);
				}
				return false;
			}

			$cache->put('diaryversioncheck', $info, $ttl);
		}

		return $info;
	}
}
?>