<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\db;

/**
 * Main used class for all acp classes.
 */
abstract class acp_main_controller
{
	/**
	 * @var string Action URL
	 */
	protected $u_action;

	/**
	 * @var string Table prefix.
	 */
	protected $table_prefix;

	/**
	 * @var string phpBB root path
	 */
	protected $root_path;

	/**
	 * @var string phpBB Extension
	 */
	protected $php_ext;

	/**
	 * @var \phpbb\language\language Language user object
	 */
	protected $language;

	/**
	 * @var \phpbb\request\request Request object
	 */
	protected $request;

	/**
	 * @var \phpbb\template\template Template object
	 */
	protected $template;

	/**
	 * @var \phpbb\user Current connected user.
	 */
	protected $user;

	/**
	 * @var \phpbb\config\db Config object
	 */
	protected $dbconfig;

	/**
	 * Constructor
	 *
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
	public function __construct($root_path, $php_ext, language $language, request $request, template $template, user $user, db $dbconfig)
	{
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->dbconfig = $dbconfig;
	}

	/**
	 * Set page url
	 *
	 * @param string $u_action Custom form action
	 *
	 * @return void
	 * @access public
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

	/**
	 * Used by derived classes to manage page.
	 *
	 * @param string $mode
	 * @param string $action
	 *
	 * @throws \Exception
	 * @return void
	 * @access public
	 */
	abstract public function do_action($mode, $action);
}
