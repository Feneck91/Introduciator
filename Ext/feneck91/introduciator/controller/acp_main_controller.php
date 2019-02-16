<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\db;

/**
 * Main class for all acp classes.
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
	 * @var string phpBB Extention
	 */
	protected $php_ext;	

	/**
	 * @var \phpbb\language\language
	 */
	protected $language;
	
	/**
	 * @var \phpbb\request\request
	 */
	protected $request;
	
	/**
	 * @var \phpbb\template\template
	 */
	protected $template;

	/**
	 * @var \phpbb\user Current connected user.
	 */
	protected $user;
	
	/**
	 * @var \phpbb\config\db
	 */
	protected $dbconfig;

	/**
	 * Constructor
	 *
	 * @param string                                             $table_prefix  Table prefix
	 * @param string                                             $root_path     phpBB root path
	 * @param string                                             $php_ext       phpBB Extention
	 * @param language                                           $language      Language user object
	 * @param request                                            $request       Request object
	 * @param template	                                         $template      Template object
	 * @param user                                               $user          User object
	 * @param db                                                 $dbconfig      Config object
	 * 
	 * @access public
	 */
	public function __construct($table_prefix, $root_path, $php_ext, language $language, request $request, template $template, user $user, db $dbconfig)
	{
		$this->table_prefix = $table_prefix;
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
	public function do_action($mode, $action)
	{
	}
}