<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use feneck91\introduciator\acp\introduciator_module;
use feneck91\introduciator\helper\introduciator_helper;
use phpbb\config\db;
use phpbb\pagination;
use phpbb\db\driver\factory;
use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;

/**
 * Class used to manage statistics acp page.
 *
 * This is the page where admin can see if some users post more than one introduce.
 */
class acp_statistics_controller extends acp_main_controller
{
	/**
	 * Number of items displayed into statistics table.
	 */
	const NUMBER_ITEMS_BY_PAGE = 10;

	/**
	 * @var \feneck91\introduciator\helper\introduciator_helper Introduciator helper. The important code is into this helper
	 */
	protected $helper;

	/**
	 * @var \phpbb\db\driver\driver_interface Database interface
	 */
	protected $db;

	/**
	 * @var \phpbb\pagination Used to manage information split to display it into several pages
	 */
	private $pagination;

	/**
	 * Constructor
	 *
	 * @param \feneck91\introduciator\helper\introduciator_helper   $helper         Extension helper
	 * @param \phpbb\db\driver\factory                              $db             Database interface
	 * @param \phpbb\pagination                                     $pagination     Used to manage information split to display it into several pages
	 * @param string                                                $table_prefix   Table prefix
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
	public function __construct(introduciator_helper $helper, factory $db, pagination $pagination, $table_prefix, $root_path, $php_ext, language $language, request $request, template $template, user $user, db $dbconfig)
	{
		$this->helper = $helper;
		$this->db = $db;
		$this->pagination = $pagination;

		parent::__construct(
			$table_prefix,
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
	 * is really comming from this extension by checking form key
	 *
	 * @param string $mode Current mode
	 * @param string $action Current action to manage:
	 *    check to display first page
	 *    otherpage to change the informations page displayed to the user
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
			switch ($action)
			{
				case 'check' :
					if (!check_form_key(introduciator_module::form_key))
					{
						trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}
					$this->do_check_action();
				break;

				case 'otherpage':
					$this->do_check_action();
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
		$this->template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
		));

		$s_hidden_fields = build_hidden_fields(array(
			'action'				=> 'check', // Action
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
	private function do_check_action()
	{
		$params = $this->helper->introduciator_getparams();

		//
		// Compute number of introductions
		//
		$sql = $this->db->sql_build_query('SELECT', array(
				'SELECT'	=> 'COUNT(topic_id)',
				'FROM'		=> array(TOPICS_TABLE => TOPICS_TABLE),
				'WHERE'		=> TOPICS_TABLE . '.topic_type = ' . POST_NORMAL . ' AND ' . TOPICS_TABLE . ".forum_id = {$params['fk_forum_id']} AND " . TOPICS_TABLE . '.topic_visibility = ' . ITEM_APPROVED,
			));
		$row = $this->db->sql_fetchrow($this->db->sql_query($sql));
		$nb_introductions = reset($row);
		$this->template->assign_vars(array(
			'INTRODUCTIONS_NUMBER' 	=> $nb_introductions,
		));

		//
		// Compute multiple introduction
		//
		$start = $this->request->variable('start', 0);
		//
		// Here, we must check database to see if some user have more than one introduction
		// 1> Get the number of introduce errors (more than once)

		$sql_where = $this->db->sql_build_query('SELECT', array(
				'SELECT'	=> 'COUNT(topic_id)',
				'FROM'		=> array(TOPICS_TABLE => TOPICS_TABLE),
				'WHERE'		=> TOPICS_TABLE . '.topic_type = ' . POST_NORMAL . ' AND phpbbtopics.topic_poster = ' . TOPICS_TABLE . '.topic_poster AND ' . TOPICS_TABLE . ".forum_id = {$params['fk_forum_id']} AND " . TOPICS_TABLE . '.topic_visibility = ' . ITEM_APPROVED,
			));
		 $sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'COUNT(result.topic_id)',
			'FROM'		=> array(
				$this->db->sql_build_query('SELECT', array(
					'SELECT'	=> 'topic_id',
					'FROM'		=> array(TOPICS_TABLE => 'phpbbtopics'),
					'WHERE'		=> "( {$sql_where} ) > 1",
					'GROUP_BY'	=> 'topic_poster',
				)) => ''),
			)) . " result";

		$row = $this->db->sql_fetchrow($this->db->sql_query($sql));
		$nb_several_introduce = reset($row);

		if ($nb_several_introduce > 0)
		{
			$sql_where = $this->db->sql_build_query('SELECT', array(
					'SELECT'	=> 'COUNT(topic_id)',
					'FROM'		=> array(TOPICS_TABLE => TOPICS_TABLE),
					'WHERE'		=> TOPICS_TABLE . '.topic_type = ' . POST_NORMAL . ' AND phpbbtopics.topic_poster = ' . TOPICS_TABLE . '.topic_poster AND ' . TOPICS_TABLE . ".forum_id = {$params['fk_forum_id']} AND " . TOPICS_TABLE . '.topic_visibility = ' . ITEM_APPROVED,
				));
			$sql = $this->db->sql_build_query('SELECT', array(
				'SELECT'	=> 'topic_poster, topic_first_poster_name',
				'FROM'		=> array(TOPICS_TABLE => 'phpbbtopics'),
				'WHERE'		=> "( {$sql_where} ) > 1",
				'GROUP_BY'	=> 'topic_poster',
				'ORDER_BY'	=> 'topic_first_poster_name',
			));

			// Get all users that post more than one introduce
			$result = $this->db->sql_query($sql);
			$all_users = array(); // Receive all users info
			while ($row = $this->db->sql_fetchrow($result))
			{
				array_push($all_users, $row);
			}
			$this->db->sql_freeresult($result);

			// For all these users, Chek to know if they are not ignored
			$users_to_check = array(); // Receive all users info
			foreach ($all_users as $user)
			{
				if ($this->helper->is_user_must_introduce_himself($user['topic_poster'], null, $user['topic_first_poster_name']))
				{
					// User is not ignored, check it
					array_push($users_to_check, $user);
				}
			}

			// Here it is the list of all user (not ignored) that have post more than one introduce
			$nb_several_introduce = count($users_to_check);

			if ($nb_several_introduce > 0)
			{
				$start = min($start, $nb_several_introduce - 1);

				for ($index = $start; $index < min($nb_several_introduce, $start + acp_statistics_controller::NUMBER_ITEMS_BY_PAGE); ++$index)
				{
					// Here, no more need to test if number of introduce > 1 because it is already done just before
					$sql = $this->db->sql_build_query('SELECT', array(
						'SELECT'    => "topic_id, topic_first_post_id, topic_title, topic_visibility, topic_time, topic_poster, topic_first_poster_name, topic_first_poster_colour, topic_type",
						'FROM'      => array(TOPICS_TABLE => TOPICS_TABLE),
						'WHERE'		=> "forum_id = {$params['fk_forum_id']} AND topic_poster = {$users_to_check[$index]['topic_poster']} AND topic_visibility = " . ITEM_APPROVED . ' AND topic_type = ' . POST_NORMAL,
						'ORDER_BY'	=> 'topic_time',
					));

					$result = $this->db->sql_query($sql);
					$first_row = true;
					while ($row = $this->db->sql_fetchrow($result))
					{
						$link_to_introduce = $this->helper->get_url_to_post($params['fk_forum_id'], $row['topic_id'], $row['topic_first_post_id']);

						$this->template->assign_block_vars('introduces', array(
							'FIRST_ROW_SPAN'	=> $first_row,
							'ROW_SPAN'			=> $result->num_rows,
							'POSTER'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
							'DATE'				=> $this->user->format_date($row['topic_time']),
							'INTRODUCE'			=> "<a href=\"{$link_to_introduce}\">{$row['topic_title']}</a>",
							'ROW_NUMBER'		=> $index - $start + 1,
						));
						$first_row = false;
					}
					$this->db->sql_freeresult($result);
				}
				$this->template->assign_vars(array(
					'S_DISPLAY_INTRODUCES'		=> ($nb_several_introduce > 0) ? true : false,
					'PAGE_NUMBER' 				=> $this->pagination->validate_start($nb_several_introduce, acp_statistics_controller::NUMBER_ITEMS_BY_PAGE, $start),
				));
				$this->pagination->generate_template_pagination($this->u_action . "&amp;action=otherpage", 'pagination', 'start', $nb_several_introduce, acp_statistics_controller::NUMBER_ITEMS_BY_PAGE, $start);
			}
		}

		$this->template->assign_vars(array(
			'U_ACTION'					=> $this->u_action,
			'S_CHECK_DATABASE'			=> true,
		));
	}
}
