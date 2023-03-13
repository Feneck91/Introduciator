<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use feneck91\introduciator\helper\introduciator_helper;
use feneck91\introduciator\acp\introduciator_module;
use phpbb\db\driver\factory;
use phpbb\log\log;
use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\db;

/**
 * Class used to manage configuration acp page.
 *
 * This is the main page used to configure most extension options.
 */
class acp_configuration_controller extends acp_main_controller
{
	/**
	 * @var introduciator_helper Introduciator helper. The important code is into this helper.
	 */
	protected $helper;

	/**
	 * @var \phpbb\db\driver\driver_interface Database interface
	 */
	protected $db;

	/**
	 * @var \phpbb\log\log Object used to add info into admin log
	 */
	protected $log;

	/**
	 * Constructor
	 *
	 * @param introduciator_helper          $helper         Extension helper
	 * @param \phpbb\db\driver\factory      $db             Database interface
	 * @param \phpbb\log\log                $log            Object used to add info into admin log
	 * @param string                        $root_path      phpBB root path
	 * @param string                        $php_ext        phpBB Extension
	 * @param \phpbb\language\language      $language       Language user object
	 * @param \phpbb\request\request        $request        Request object
	 * @param \phpbb\template\template      $template       Template object
	 * @param \phpbb\user                   $user           User object
	 * @param \phpbb\config\db              $dbconfig       Config object
	 *
	 * @access public
	 */
	public function __construct(introduciator_helper $helper, factory $db, log $log, $root_path, $php_ext, language $language, request $request, template $template, user $user, db $dbconfig)
	{
		$this->helper = $helper;
		$this->db = $db;
		$this->log = $log;

		parent::__construct(
			$root_path,
			$php_ext,
			$language,
			$request,
			$template,
			$user,
			$dbconfig
		);
 	}

	/**
	 * Manage the page.
	 *
	 * When action is empty, the page is filled with current extension configuration, else it check if the current action
	 * is really coming from this extension by checking form key.
	 *
	 * @param string $mode Current mode
	 * @param string $action Current action to manage
	 *
	 * @throws \Exception
	 * @return void
	 * @access public
	 */
	public function do_action($mode, $action)
	{
		// If no action, display configuration
		if (empty($action))
		{
			// no action or update current
			$this->display_configuration();
		}
		else
		{
			// Action !
			if (!check_form_key(introduciator_module::form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			if ($action != 'update')
			{
				trigger_error($this->language->lang('NO_MODE') . adm_back_link($this->u_action));
			}
			$this->do_update_action();
		}
	}

	/**
	 * Manage the page: fill content.
	 *
	 * @throws \Exception
	 * @return void
	 * @access private
	 */
	private function display_configuration()
	{
		$params = $this->helper->introduciator_getparams(true);
		$this->template->assign_vars(array(
			'INTRODUCIATOR_EXTENSION_ACTIVATED'					=> $params['introduciator_allow'],
			'INTRODUCIATOR_INTRODUCTION_MANDATORY'				=> $params['is_introduction_mandatory'],
			'INTRODUCIATOR_CHECK_DELETE_FIRST_POST_ACTIVATED'	=> $params['is_check_delete_first_post'],
			'APPROVAL_LEVEL_NO_APPROVAL_ENABLED'				=> $params['posting_approval_level'] == introduciator_helper::APPROVAL_LEVEL_NO_APPROVAL,
			'APPROVAL_LEVEL_APPROVAL_ENABLED'					=> $params['posting_approval_level'] == introduciator_helper::APPROVAL_LEVEL_APPROVAL,
			'APPROVAL_LEVEL_NO_APPROVAL_WITH_EDIT_ENABLED'		=> $params['posting_approval_level'] == introduciator_helper::APPROVAL_LEVEL_APPROVAL_WITH_EDIT,
			'INTRODUCIATOR_USE_PERMISSIONS'						=> $params['is_use_permissions'],
			'INTRODUCIATOR_INCLUDE_GROUPS_SELECTED'				=> $params['is_include_groups'],
			'INTRODUCIATOR_ITEM_IGNORED_USERS'					=> $params['ignored_users'],
			'INTRODUCIATOR_DISPLAY_PERMISSIONS_GROUP'			=> $params['is_use_permissions'] ? "none" : "block",
			'U_ACTION'											=> $this->u_action,
		));

		// Add all forums
		$this->add_all_forums($params['fk_forum_id'], 0, 0);

		// Add all groups
		$this->add_all_groups();

		$s_hidden_fields = build_hidden_fields(array(
			'action'				=> 'update',					// Action
		));

		$this->template->assign_var('S_HIDDEN_FIELDS', $s_hidden_fields);
	}

	/**
	 * Verify the approval level value => Incorrect value? Set to APPROVAL_LEVEL_NO_APPROVAL
	 *
	 * @param int $posting_approval_level
	 *
	 * @return int
	 * @access private
	 */
	private function check_approval_value($posting_approval_level)
	{
		if ($posting_approval_level != introduciator_helper::APPROVAL_LEVEL_NO_APPROVAL
			&& $posting_approval_level != introduciator_helper::APPROVAL_LEVEL_APPROVAL
			&& $posting_approval_level != introduciator_helper::APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
		{
			$posting_approval_level = introduciator_helper::APPROVAL_LEVEL_NO_APPROVAL;
		}
		return $posting_approval_level;
	}

	/**
	 * Manage the page: fill database with form content post by user.
	 *
	 * @throws \Exception
	 * @return void
	 * @access private
	 */
	private function do_update_action()
	{
		// User has request an update : write it into database
		// Update Database
		$is_enabled									= $this->request->variable('extension_activated', false);
		$is_check_introduction_mandatory_activated  = $this->request->variable('check_introduction_mandatory_activated', true);
		$is_check_delete_first_post_activated		= $this->request->variable('check_delete_first_post_activated', false);
		$fk_forum_id								= $this->request->variable('forum_choice', 0);
		$posting_approval_level						= $this->request->variable('posting_approval_level', introduciator_helper::APPROVAL_LEVEL_NO_APPROVAL);
		$is_use_permissions							= $this->request->variable('is_use_permissions', true);
		$is_include_groups							= $this->request->variable('include_groups', true);
		$groups										= $this->request->variable('groups_choices', array('' => 0)); // Array of IDs of selected groups
		$ignored_users								= substr($this->request->variable('ignored_users', ''), 0, 255);

		if ($is_enabled && $fk_forum_id === 0)
		{
			trigger_error($this->language->lang('INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM') . adm_back_link($this->u_action), E_USER_WARNING);
		}

		$this->dbconfig->set('introduciator_allow', $is_enabled); // Set the activation extension config
		$this->dbconfig->set('introduciator_is_introduction_mandatory', $is_check_introduction_mandatory_activated);
		$this->dbconfig->set('introduciator_is_check_delete_first_post', $is_check_delete_first_post_activated);
		$this->dbconfig->set('introduciator_fk_forum_id', $fk_forum_id);
		$this->dbconfig->set('introduciator_posting_approval_level', $this->check_approval_value($posting_approval_level));
		$this->dbconfig->set('introduciator_is_use_permissions', $is_use_permissions);
		$this->dbconfig->set('introduciator_is_include_groups', $is_include_groups);
		$this->dbconfig->set('introduciator_ignored_users', $ignored_users);

		// Update INTRODUCIATOR_GROUPS_TABLE
		// 1> Remove all entries
		$sql = 'DELETE FROM ' . $this->helper->get_introduciator_groups_table();
		$this->db->sql_query($sql);

		// 2> Add all entries
		$values = array();
		foreach ($groups as $group)
		{
			// Create elements to add by row
			$values[] = array('fk_group' => (int) $group);
		}

		// Create and execute SQL request
		$this->db->sql_multi_insert($this->helper->get_introduciator_groups_table(), $values);

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INTRODUCIATOR_UPDATED');
		trigger_error($this->language->lang('INTRODUCIATOR_CP_LOG_UPDATED') . adm_back_link($this->u_action));
	}

	/**
	 * Add all forum recursivly to template 'forums' var.
	 *
	 * Used to fill the template 'forums' var to be able to show to the user all available
	 * forums with correct hierarchy.
	 *
	 * @param int $fk_selected_forum_id the current selected forum id.
	 * @param int $id_parent the parent's forum id, if 0 it is the root one.
	 * @param int $level hierarchy level, 0 for root, 1 for children, 2 for children's children, etc.
	 *
	 * @return void
	 * @access private
	 */
	private function add_all_forums($fk_selected_forum_id, $id_parent, $level)
	{
		if ((int) $id_parent === 0)
		{
			// Add deactivation item
			$this->template->assign_block_vars('forums', array(
				'FORUM_NAME'	=> $this->language->lang('INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'),
				'FORUM_ID'		=> 0,
				'SELECTED'		=> (int) $fk_selected_forum_id === 0,
				'CAN_SELECT'	=> true,
				'TOOLTIP'		=> $this->language->lang('INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'),
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
				'SELECTED'		=> (int) $fk_selected_forum_id== (int) $row['forum_id'],
				'CAN_SELECT'	=> (int) $row['forum_type'] === FORUM_POST,
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
	 *
	 * @return void
	 * @access private
	 */
	private function add_all_groups()
	{
		if (!function_exists('get_group_name'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		$sql = 'SELECT group_id, group_desc
			FROM ' . GROUPS_TABLE;

		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('groups', array(
				'NAME'		=> get_group_name($row['group_id']),
				'ID'		=> (int) $row['group_id'],
				'SELECTED'	=> $this->helper->is_group_selected($row['group_id']),
				'TOOLTIP'	=> $row['group_desc'],
			));
		}
		$this->db->sql_freeresult($result);
	}
}
