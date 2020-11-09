<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
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
 * Class used to manage explanation acp page.
 *
 * This is the page used to configure the explanation informations displayed to the user when
 * he try to post a message without beeing introduce.
 *
 */
class acp_explanation_controller extends acp_main_controller
{
	/**
	 * @var \feneck91\introduciator\helper\introduciator_helper Introduciator helper. The important code is into this helper
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
	 * @param \feneck91\introduciator\helper\introduciator_helper   $helper         Extension helper
	 * @param \phpbb\db\driver\factory                              $db             Database interface
	 * @param \phpbb\log\log                                        $log            Object used to add info into admin log
	 * @param string                                                $root_path      phpBB root path
	 * @param string                                                $php_ext        phpBB Extention
	 * @param \phpbb\language\language                              $language       Language user object
	 * @param \phpbb\request\request                                $request        Request object
	 * @param \phpbb\template\template                              $template       Template object
	 * @param \phpbb\user                                           $user           User object
	 * @param \phpbb\config\db                                      $dbconfig       Config object
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
	 * is really comming from this extension by checking form key.
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
		{	// no action or update current
			$this->do_empty_action();
		}
		else
		{
			// Action !
			if (!check_form_key(introduciator_module::form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			switch ($action)
			{
				case 'update' :
					$this->do_update_action();
				break;

				default:
					trigger_error($this->language->lang('NO_MODE') . adm_back_link($this->u_action));
				break;
			}
		}
	}

	/**
	 * Manage the page: fill content.
	 *
	 * @throws \Exception
	 * @return void
	 * @access private
	 */
	private function do_empty_action()
	{
		// no action or update current
		$params = $this->helper->introduciator_getparams(true);
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
		// Verify message rules texts and convert with BBCode
		$is_explanation_enabled				= $this->request->variable('display_explanation', false);
		$explanation_display_rules_enabled	= $this->request->variable('explanation_display_rules_enabled', false);
		$explanation_message_array_result	= array();

		// Get All languages
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'l.lang_iso',
			'FROM'		=> array(LANG_TABLE => 'l'),
			'ORDER BY'	=> 'lang_id',
		));
		$result = $this->db->sql_query($sql);

		// Fill $explanation_message_array_result
		while ($row = $this->db->sql_fetchrow($result))
		{
			$iso = $row['lang_iso'];
			$explanation_message_title	= $this->request->variable("explanation_message_title_$iso", '', true);
			$explanation_message_text	= $this->request->variable("explanation_message_text_$iso", '', true);
			$explanation_rules_title	= $this->request->variable("explanation_rules_title_$iso", '', true);
			$explanation_rules_text		= $this->request->variable("explanation_rules_text_$iso", '', true);

			// Replace all url by real fake urls
			$this->helper->replace_all_by(
				array(
					&$explanation_message_title,
					&$explanation_message_text,
					&$explanation_rules_title,
					&$explanation_rules_text,
				),
				array(
					'%forum_url%'	=> 'http://aghxkfps.tld', // Make link work if placed into [url]
					'%forum_post%'	=> 'http://dqsdfzef.tld', // Make link work if placed into [url]
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
		$sql = 'DELETE FROM ' . $this->helper->get_introduciator_explanation_table();
		$this->db->sql_query($sql);

		// 2> Add all entries
		// Create and execute SQL request
		$this->db->sql_multi_insert($this->helper->get_introduciator_explanation_table(), $explanation_message_array_result);

		// 3> Set enabled explanations
		$this->dbconfig->set('introduciator_is_explanation_enabled', $is_explanation_enabled ? '1' : '0');
		$this->dbconfig->set('introduciator_is_explanation_display_rules', $explanation_display_rules_enabled ? '1' : '0');

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED');
		trigger_error($this->language->lang('INTRODUCIATOR_EP_UPDATED') . adm_back_link($this->u_action));
	}
}
