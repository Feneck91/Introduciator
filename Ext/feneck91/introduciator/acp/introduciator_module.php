<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\acp;

/**
 * Module to manage ACP extension configuration.
 */
class introduciator_module
{
	/**
	 * URL of web site where download the latest version file info
	 */
	protected $url_version_check		= 'feneck91.free.fr';
	
	/**
	 * Folder in web site where download the latest version file info
	 */
	protected $folder_version_check		= '/phpbb';
	
	/**
	 * File name to download the latest version file info
	 */
	protected $file_version_check		= 'introduciator_extension_version.txt';
	
	/**
	 *  Action
	 */
	public $u_action;

	/**
	 * Template name
	 */
	public $tpl_name;
	
	/**
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	private $container;

	/**
	 * @var \phpbb\language\language
	 */
	private $language;

	/**
	 * @var \phpbb\pagination
	 */
	private $pagination;
	
	/**
	 * @var \phpbb\request\request
	 */
	private $request;
	
	/**
	 * @var \phpbb\template\template
	 */
	private $template;
	
	/**
	 * @var \phpbb\db\driver\driver_interface
	 */
	private $db;

	/**
	 * @var \phpbb\user Current connected user.
	 */
	private $user;
	
	public function main($id, $mode)
	{
		global $phpbb_container;
		$this->container = $phpbb_container;
		$this->language = $phpbb_container->get('language');
		$this->pagination = $phpbb_container->get('pagination');
		$this->request = $phpbb_container->get('request');
		$this->template = $this->container->get('template');
		$this->db = $this->container->get('dbal.conn');
		$this->user = $this->container->get('user');
		$config = $this->container->get('config');
		$phpbb_log = $this->container->get('log');

		// Add a secret token to the form
		// This functions adds a secret token to any form, a token which should be checked after
		// submission with the check_form_key function to ensure that the received data is the same as the submitted.
		$form_key = 'feneck91/acp_introduciator';
		add_form_key($form_key);

		switch ($mode)
		{
			case 'general':
				global $phpbb_admin_path, $phpEx;

				// Set the template for this module
				$this->tpl_name = 'acp_introduciator_general'; // Template file : adm/style/introduciator/acp_introduciator_general.htm
				$this->page_title = 'INTRODUCIATOR_GENERAL';
				
				// Check if a new version of this extension is available
				$latest_version_info = $this->obtain_latest_version_info($this->request->variable('introduciator_versioncheck_force', false));

				if ($latest_version_info === false || !function_exists('phpbb_version_compare'))
				{
					$this->template->assign_var('S_INTRODUCIATOR_VERSIONCHECK_FAIL', true);
				}
				else
				{
					$latest_version_info = explode("\n", $latest_version_info);
					$version_check = $this->get_update_information('url-', $latest_version_info);
					$infos = $this->get_update_information('info-', $latest_version_info);

					$this->template->assign_vars(array(
						'S_INTRODUCIATOR_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $config['introduciator_extension_version'], '<='),
						'S_INTRODUCIATOR_VERSIONCHECK_URL_FOUND'=> $version_check[1],
						'U_INTRODUCIATOR_VERSIONCHECK'			=> $version_check[0],
						'L_INTRODUCIATOR_UPDATE_VERSION'		=> trim($latest_version_info[0]),
						'L_INTRODUCIATOR_UPDATE_FILENAME'		=> trim(sizeof($latest_version_info) < 3 ? '' : $latest_version_info[2]),
						'U_INTRODUCIATOR_UPDATE_URL'			=> trim(sizeof($latest_version_info) < 4 ? '' : $latest_version_info[3]),
						'L_INTRODUCIATOR_UPDATE_INFORMATION'	=> $infos[0],
					));
				}

				$this->template->assign_vars(array(
					// Display general page content into ACP Extensions tab
					'S_INTRODUCIATOR_GENERAL_PAGES'			=> true,

					// Current version of this extension
					'INTRODUCIATOR_VERSION'					=> $config['introduciator_extension_version'],
					// Install date of this extension
					'INTRODUCIATOR_INSTALL_DATE'			=> $this->user->format_date($config['introduciator_install_date']),

					// Check force URL
					// i is the ID of this extension's module (-feneck91-introduciator-acp-introduciator_module) / mode is the sub item
					'U_INTRODUCIATOR_VERSIONCHECK_FORCE'	=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=-feneck91-introduciator-acp-introduciator_module&amp;mode=' . $mode . '&amp;introduciator_versioncheck_force=1'),
					'U_ACTION'								=> $this->u_action,
				));
			break;

			case 'configuration':
				// Get Action
				$action = $this->request->variable('action', '');

				// Set the template for this module
				$this->tpl_name = 'acp_introduciator_configuration'; // Template file : adm/style/introduciator/acp_introduciator_configuration.htm
				$this->page_title = 'INTRODUCIATOR_CONFIGURATION';

				// Get Introduciator class helper
				$introduciator_helper = $this->container->get('feneck91.introduciator.helper');

				// If no action, display configuration
				if (empty($action))
				{	// no action or update current
					$params = $introduciator_helper->introduciator_getparams(true);
					$this->template->assign_vars(array(
						'INTRODUCIATOR_EXTENSION_ACTIVATED'										=> $params['introduciator_allow'],
						'INTRODUCIATOR_INTRODUCTION_MANDATORY'									=> $params['is_introduction_mandatory'],
						'INTRODUCIATOR_CHECK_DELETE_FIRST_POST_ACTIVATED'						=> $params['is_check_delete_first_post'],
						'INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL_ENABLED'				=> $params['posting_approval_level'] == $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL,
						'INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_ENABLED'					=> $params['posting_approval_level'] == $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL,
						'INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL_WITH_EDIT_ENABLED'	=> $params['posting_approval_level'] == $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT,
						'INTRODUCIATOR_USE_PERMISSIONS'											=> $params['is_use_permissions'],
						'INTRODUCIATOR_INCLUDE_GROUPS_SELECTED'									=> $params['is_include_groups'],
						'INTRODUCIATOR_ITEM_IGNORED_USERS'										=> $params['ignored_users'],
						'U_ACTION'																=> $this->u_action,
					));

					// Add all forums
					$this->add_all_forums($params['fk_forum_id'], 0, 0);

					// Add all groups
					$this->add_all_groups($introduciator_helper);

					$s_hidden_fields = build_hidden_fields(array(
						'action'				=> 'update',					// Action
					));

					$this->template->assign_var('S_HIDDEN_FIELDS', $s_hidden_fields);
				}
				else
				{	// Action !
					if (!check_form_key($form_key))
					{
						trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}
					switch ($action)
					{
						case 'update' :
							// User has request an update : write it into database
							// Update Database
							$is_enabled									= $this->request->variable('extension_activated', false);
							$is_check_introduction_mandatory_activated  = $this->request->variable('check_introduction_mandatory_activated', true);
							$is_check_delete_first_post_activated		= $this->request->variable('check_delete_first_post_activated', false);
							$fk_forum_id								= $this->request->variable('forum_choice', 0);
							$posting_approval_level						= $this->request->variable('posting_approval_level', $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL);
							$is_use_permissions							= $this->request->variable('is_use_permissions', true);
							$is_include_groups							= $this->request->variable('include_groups', true);
							$groups										= $this->request->variable('groups_choices', array('' => 0)); // Array of IDs of selected groups
							$ignored_users								= substr(utf8_normalize_nfc($this->request->variable('ignored_users', '')), 0, 255);

							if ($is_enabled && $fk_forum_id === 0)
							{
								trigger_error($this->language->lang('INTRODUCIATOR_ERROR_MUST_SELECT_FORUM') . adm_back_link($this->u_action), E_USER_WARNING);
							}

							if ($posting_approval_level != $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL && $posting_approval_level != $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL && $posting_approval_level != $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
							{	// Verify the level approval values => No correct value ? Set to INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL
								$posting_approval_level = $introduciator_helper::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL;
							}
									
							$config->set('introduciator_allow', $is_enabled ? '1' : '0'); // Set the activation extension config
							$config->set('introduciator_is_introduction_mandatory', $is_check_introduction_mandatory_activated ? '1' : '0');
							$config->set('introduciator_is_check_delete_first_post', $is_check_delete_first_post_activated ? '1' : '0');
							$config->set('introduciator_fk_forum_id', $fk_forum_id);
							$config->set('introduciator_posting_approval_level', $posting_approval_level);
							$config->set('introduciator_is_use_permissions', $is_use_permissions ? '1' : '0');
							$config->set('introduciator_is_include_groups', $is_include_groups ? '1' : '0');
							$config->set('introduciator_ignored_users', $ignored_users);

							// Update INTRODUCIATOR_GROUPS_TABLE
							// 1> Remove all entries
							$sql = 'DELETE FROM ' . $introduciator_helper->Get_INTRODUCIATOR_GROUPS_TABLE();
							$this->db->sql_query($sql);

							// 2> Add all entries
							$values = array();
							foreach ($groups as &$group)
							{	// Create elements to add by row
								$values[] = array('fk_group' => (int) $group);
							}
							// Create and execute SQL request
							$this->db->sql_multi_insert($introduciator_helper->Get_INTRODUCIATOR_GROUPS_TABLE(), $values);

							$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_INTRODUCIATOR_UPDATED');
							trigger_error($this->language->lang('INTRODUCIATOR_CP_UPDATED') . adm_back_link($this->u_action));
							break;

						default:
							trigger_error($this->language->lang('NO_MODE') . adm_back_link($this->u_action));
							break;
					} // End of switch Action
				} // End of switch configuration
			break;
			
			case 'explanation':
				// Get Action
				$action = $this->request->variable('action', '');

				// Set the template for this module
				$this->tpl_name = 'acp_introduciator_explanation'; // Template file : adm/style/introduciator/acp_introduciator_explanation.htm
				$this->page_title = 'INTRODUCIATOR_EXPLANATION';

				// Get Introduciator class helper
				$introduciator_helper = $this->container->get('feneck91.introduciator.helper');
				
				// If no action, display configuration
				if (empty($action))
				{	// no action or update current
					$params = $introduciator_helper->introduciator_getparams(true);
					$this->template->assign_vars(array(
						'INTRODUCIATOR_DISPLAY_EXPLANATION_ENABLED'								=> $params['is_explanation_enabled'],
						'INTRODUCIATOR_EXPLANATION_IS_DISPLAY_RULES_ENABLED'					=> $params['is_explanation_display_rules'],
						'U_ACTION'																=> $this->u_action,
					));
					
					$i = 1;
					foreach ($params['explanations'] as $explanation_value)
					{
						$explanation = $explanation_value['explanation'];
						$this->template->assign_block_vars('explanations', array(
							'LANG_NR'									=> $i,
							'LANG_NAME'									=> $explanation_value['lang_local_name'],
							'LANG_ISO'									=> $explanation_value['lang_iso'],
							'INTRODUCIATOR_EXPLANATION_MESSAGE_TITLE'	=> $explanation['edit_message_title'],
							'INTRODUCIATOR_EXPLANATION_MESSAGE_TEXT'	=> $explanation['edit_message_text'],
							'INTRODUCIATOR_EXPLANATION_RULES_TITLE'		=> $explanation['edit_rules_title'],
							'INTRODUCIATOR_EXPLANATION_RULES_TEXT'		=> $explanation['edit_rules_text'],
						));
						$i++;
					}

					$s_hidden_fields = build_hidden_fields(array(
						'action'				=> 'update',					// Action
					));

					$this->template->assign_var('S_HIDDEN_FIELDS', $s_hidden_fields);
				}
				else
				{	// Action !
					if (!check_form_key($form_key))
					{
						trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}
					switch ($action)
					{
						case 'update' :
							// User has request an update : write it into database
							// Update Database
							// Verify message rules texts and convert with BBCode
							$is_explanation_enabled				= $this->request->variable('display_explanation', false);
							$explanation_display_rules_enabled	= $this->request->variable('explanation_display_rules_enabled', false);
							$explanation_message_array_result	= array();

							// Get All languages
							$sql = $this->db->sql_build_query('SELECT', array(
								'SELECT'    => 'l.lang_iso',
								'FROM'      => array(LANG_TABLE => 'l'),
								'ORDER BY'	=> 'lang_id',
							));
							$result = $this->db->sql_query($sql);
							// Fill $explanation_message_array_result
							while ($row = $this->db->sql_fetchrow($result))
							{
								$iso = $row['lang_iso'];
								$explanation_message_title	= utf8_normalize_nfc($this->request->variable("explanation_message_title_$iso", '', true));
								$explanation_message_text	= utf8_normalize_nfc($this->request->variable("explanation_message_text_$iso", '', true));
								$explanation_rules_title	= utf8_normalize_nfc($this->request->variable("explanation_rules_title_$iso", '', true));
								$explanation_rules_text		= utf8_normalize_nfc($this->request->variable("explanation_rules_text_$iso", '', true));

								// Replace all url by real fake urls
								$introduciator_helper->replace_all_by(
									array(
										&$explanation_message_title,
										&$explanation_message_text,
										&$explanation_rules_title,
										&$explanation_rules_text,
									),
									array(
										'%forum_url%'	=> 'http://aghxkfps.com', // Make link work if placed into [url]
										'%forum_post%'	=> 'http://dqsdfzef.com', // Make link work if placed into [url]
									)
								);

								$explanation_message_array = array(
									'message_title'		=> $explanation_message_title,
									'message_text'		=> $explanation_message_text,
									'rules_title'		=> $explanation_rules_title,
									'rules_text'		=> $explanation_rules_text,
								);
								
								// One row result
								$explanation_message_array_row_result = array(
									'lang'	=> $iso,
								);
								// Verify all user inputs and get uuid / bitfield / bbcode_options
								foreach ($explanation_message_array as $key => $value)
								{
									$new_uid = $bitfield = $bbcode_options = '';
									$texts_errors = generate_text_for_storage($value, $new_uid, $bitfield, $bbcode_options, true, true, true);
									if (sizeof($texts_errors))
									{	// Errors occured, show them to the user (split br else MPV found an error because /> is not written
										trigger_error(implode('<b' . 'r>', $texts_errors) . adm_back_link($this->u_action), E_USER_WARNING);
									}
									// Merge results into array
									$explanation_message_array_row_result = array_merge($explanation_message_array_row_result, array(
										$key						=> $value,
										$key . '_uid'				=> $new_uid,
										$key . '_bitfield'			=> $bitfield,
										$key . '_bbcode_options'	=> $bbcode_options,
									));
								}
								array_push($explanation_message_array_result, $explanation_message_array_row_result);
							}
							
							// Update INTRODUCIATOR_EXPLANATION_TABLE
							// 1> Remove all entries
							$sql = 'DELETE FROM ' . $introduciator_helper->Get_INTRODUCIATOR_EXPLANATION_TABLE();
							$this->db->sql_query($sql);

							// 2> Add all entries
							// Create and execute SQL request
							$this->db->sql_multi_insert($introduciator_helper->Get_INTRODUCIATOR_EXPLANATION_TABLE(), $explanation_message_array_result);

							// 3> Set enabled explanations
							$config->set('introduciator_is_explanation_enabled', $is_explanation_enabled ? '1' : '0');
							$config->set('introduciator_is_explanation_display_rules', $explanation_display_rules_enabled ? '1' : '0');

							$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_INTRODUCIATOR_EXPLANATION_UPDATED');
							trigger_error($this->language->lang('INTRODUCIATOR_CP_UPDATED') . adm_back_link($this->u_action));
							break;

						default:
							trigger_error($this->language->lang('NO_MODE') . adm_back_link($this->u_action));
							break;
					} // End of switch Action
				}
			break;
			
			case 'statistics':
				// Get Action
				$start = $this->request->variable('start', 0);
				$action = $this->request->variable('action', '');
				$number_item_per_page = 10; // Number of items by page

				// Set the template for this module
				$this->tpl_name = 'acp_introduciator_statistics'; // Template file : adm/style/introduciator/acp_introduciator_statistics.htm
				$this->page_title = 'INTRODUCIATOR_STATISCICS';

				// Get Introduciator class helper
				$introduciator_helper = $this->container->get('feneck91.introduciator.helper');
				$params = $introduciator_helper->introduciator_getparams();
				if (!$introduciator_helper->is_introduciator_allowed())
				{	// The introduciator must be enable else it can be not configure correctly
					trigger_error($this->language->lang('INTRODUCIATOR_NOT_ENABLED_FOR_STATISTICS') . adm_back_link($this->u_action), E_USER_WARNING);
				}
				
				// If no action, display configuration
				if (empty($action))
				{	// no action or update current
					$this->template->assign_vars(array(
						'U_ACTION'				=> $this->u_action,
					));
					
					$s_hidden_fields = build_hidden_fields(array(
						'action'				=> 'check', // Action
					));

					$this->template->assign_var('S_HIDDEN_FIELDS', $s_hidden_fields);
				}
				else
				{					
					switch ($action)
					{
						case 'check' :
							if (!check_form_key($form_key))
							{
								trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
							}
							break;
						case 'otherpage' :
							// Here: no check_form_key, it doesn't work
							break;
					}
					switch ($action)
					{
						case 'check' :
							// No break
						case 'otherpage' :
							// Here, we must check database to see if some user have more than one introduction
							// 1> Get the number of introduce errors (more than once)
							 $sql = $this->db->sql_build_query('SELECT', array(
								'SELECT'	=> 'COUNT(result.topic_id)',
								'FROM'		=> array(
									$this->db->sql_build_query('SELECT', array(
										'SELECT'	=> 'topic_id',
										'FROM'		=> array(TOPICS_TABLE => 'phpbbtopics'),
										'WHERE'		=> '(' . $this->db->sql_build_query('SELECT', array(
											'SELECT'	=> 'COUNT(topic_id)',
											'FROM'		=> array(TOPICS_TABLE => TOPICS_TABLE),
											'WHERE'		=> 'phpbbtopics.topic_poster = ' . TOPICS_TABLE . '.topic_poster AND ' . TOPICS_TABLE . ".forum_id = {$params['fk_forum_id']} AND " . TOPICS_TABLE . '.topic_visibility = ' . ITEM_APPROVED,
										)) . ') > 1',
										'GROUP_BY'	=> 'topic_poster',
									)) => ''),
								)) . " result";
							$row = $this->db->sql_fetchrow($this->db->sql_query($sql));
							$nb_several_introduce = reset($row);
							
							if ($nb_several_introduce > 0)
							{
								$users_to_check = array(); // Receive all users info
								
								$sql = $this->db->sql_build_query('SELECT', array(
									'SELECT'	=> 'topic_poster, topic_first_poster_name',
									'FROM'		=> array(TOPICS_TABLE => 'phpbbtopics'),
									'WHERE'		=> '(' . $this->db->sql_build_query('SELECT', array(
										'SELECT'	=> 'COUNT(topic_id)',
										'FROM'		=> array(TOPICS_TABLE => TOPICS_TABLE),
										'WHERE'		=> 'phpbbtopics.topic_poster = ' . TOPICS_TABLE . '.topic_poster AND ' . TOPICS_TABLE . ".forum_id = {$params['fk_forum_id']} AND " . TOPICS_TABLE . '.topic_visibility = ' . ITEM_APPROVED,
									)) . ') > 1',
									'GROUP_BY'	=> 'topic_poster',
									'ORDER_BY'	=> 'topic_first_poster_name',
								));
								// Chek all users to know if they are not ignored
								$result = $this->db->sql_query($sql);
								while ($row = $this->db->sql_fetchrow($result))
								{
									if ($introduciator_helper->is_user_must_introduce_himself($row['topic_poster'], null, $row['topic_first_poster_name']))
									{
										// User is not ignored, check it
										array_push($users_to_check, $row);
									}
								}
								$this->db->sql_freeresult($result);
								
								// Here it is the list of all user (not ignored) that have post more than one introduce
								$nb_several_introduce = count($users_to_check);

								if ($nb_several_introduce > 0)
								{
									$start = min($start, $nb_several_introduce - 1);

									for ($index = $start; $index < min($nb_several_introduce, $start + $number_item_per_page); ++$index)
									{
										$sql = $this->db->sql_build_query('SELECT', array(
											'SELECT'    => "topic_id, topic_first_post_id, topic_title, topic_visibility, topic_time, topic_poster, topic_first_poster_name, topic_first_poster_colour, (SELECT COUNT(topic_id) FROM phpbb_topics WHERE phpbbtopics.topic_poster = phpbb_topics.topic_poster AND forum_id = {$params['fk_forum_id']}) as nb_introduce",
											'FROM'      => array(TOPICS_TABLE => 'phpbbtopics'),
											'WHERE'		=> "forum_id = {$params['fk_forum_id']} HAVING nb_introduce > 1 AND topic_poster = {$users_to_check[$index]['topic_poster']} AND topic_visibility = " . ITEM_APPROVED,
											'ORDER_BY'	=> 'topic_time',
										));

										$result = $this->db->sql_query($sql);
										$num_rows = mysqli_num_rows($result);
										$first_row = true;
										while ($row = $this->db->sql_fetchrow($result))
										{
											$link_to_introduce = $introduciator_helper->get_url_to_post($params['fk_forum_id'], $row['topic_id'], $row['topic_first_post_id']);
											
											$this->template->assign_block_vars('introduces', array(
												'FIRST_ROW_SPAN'	=> $first_row,
												'ROW_SPAN'			=> $num_rows,
												'POSTER'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
												'DATE'				=> $this->user->format_date($row['topic_time']),
												'INTRODUCE'			=> "<a href='{$link_to_introduce}'>{$row['topic_title']}</a>",
												'ROW_NUMBER'		=> $index - $start + 1,
											));
											$first_row = false;
										}
										$this->db->sql_freeresult($result);
									}
									$this->template->assign_vars(array(
										'S_DISPLAY_INTRODUCES'		=> ($nb_several_introduce > 0) ? true : false,
										'PAGE_NUMBER' 				=> $this->pagination->validate_start($nb_several_introduce, $number_item_per_page, $start),	
									));
									$this->pagination->generate_template_pagination($this->u_action . "&amp;action=otherpage", 'pagination', 'start', $nb_several_introduce, $number_item_per_page, $start);
								}
							}

							$this->template->assign_vars(array(
								'U_ACTION'					=> $this->u_action,
								'S_CHECK_DATABASE'			=> true,
							));
							break;

						default:
							trigger_error($this->language->lang('NO_MODE') . adm_back_link($this->u_action));
							break;
					} // End of switch Action
				}
			break;			
		}
	}

	function add_all_forums($fk_selected_forum_id, $id_parent, $level)
	{
		if ($id_parent === 0)
		{	// Add deactivation item
			$this->template->assign_block_vars('forums', array(
				'FORUM_NAME'	=> $this->language->lang('INTRODUCIATOR_NO_FORUM_CHOICE'),
				'FORUM_ID'		=> (int) 0,
				'SELECTED'		=> ($fk_selected_forum_id === 0),
				'CAN_SELECT'	=> true,
				'TOOLTIP'		=> $this->language->lang('INTRODUCIATOR_NO_FORUM_CHOICE_TOOLTIP'),
			));
		}

		// Add all forums
		$sql = 'SELECT forum_name, forum_id, forum_desc, forum_type
				FROM ' . FORUMS_TABLE . '
				WHERE parent_id = ' . (int) $id_parent;

		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('forums', array(
				'FORUM_NAME'	=> str_repeat("&nbsp;", 4 * $level) . $row['forum_name'],
				'FORUM_ID'		=> (int) $row['forum_id'],
				'SELECTED'		=> ($fk_selected_forum_id == $row['forum_id']),
				'CAN_SELECT'	=> ((int) $row['forum_type']) == FORUM_POST,
				'TOOLTIP'		=> $row['forum_desc'],
			));
			$this->add_all_forums($fk_selected_forum_id, $row['forum_id'], $level + 1);
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * Find all groups to propose it to the user.
	 *
	 * Add all elements into the template.
	 */
	function add_all_groups($introduciator_helper)
	{
		$sql = 'SELECT group_id, group_desc
			FROM ' . GROUPS_TABLE;

		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('group', array(
				'NAME'		=> get_group_name($row['group_id']),
				'ID'		=> (int) $row['group_id'],
				'SELECTED'	=> $introduciator_helper->is_group_selected($row['group_id']),
				'TOOLTIP'	=> $row['group_desc'],
			));
		}
		$this->db->sql_freeresult($result);
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
		global $tag_and_lang, $tag_and_lang_en, $tag_len;

		$information = $this->language->lang('INTRODUCIATOR_NO_UPDATE_INFO_FOUND');
		$found = false;

		$tag_and_lang = '[' . $tag . $this->language->lang('USER_LANG') . ']';
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