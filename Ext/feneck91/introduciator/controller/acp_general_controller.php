<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use \feneck91\introduciator\helper\extension_manager_helper;
use \phpbb\template\template;
use \phpbb\user;
use \phpbb\config\db;

/**
 * Class used to manage general acp page.
 *
 * This is the page used to display current version, installed date version and check if new version is avalaible.
 */
class acp_general_controller
{
	/**
	 * @var string The phpBB admin path.
	 */
	/**
	 * @var \feneck91\introduciator\helper\extension_manager_helper Extension manager object
	 */
	protected $ext_manager_helper;

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
	 * @param \feneck91\introduciator\helper\extension_manager_helper       $ext_manager_helper         Extension manager object
	 * @param \phpbb\template\template                                      $template                   Template object
	 * @param \phpbb\user                                                   $user                       User object
	 * @param \phpbb\config\db                                              $dbconfig                   Config object
	 *
	 * @access public
	 */
	public function __construct(extension_manager_helper $ext_manager_helper, template $template, user $user, db $dbconfig)
	{
		$this->ext_manager_helper = $ext_manager_helper;
		$this->template = $template;
		$this->user = $user;
		$this->dbconfig = $dbconfig;
 	}

	/**
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
		//Load metadata for this extension
		$ext_meta = $this->ext_manager_helper->get_ext_meta();

		$this->template->assign_vars(array(
			// Display general page content into ACP Extensions tab
			'S_INTRODUCIATOR_GENERAL_PAGES'			=> true,
			// Current version of this extension
			'INTRODUCIATOR_VERSION'					=> $ext_meta['version'],
			// Install date of this extension
			'INTRODUCIATOR_INSTALL_DATE'			=> $this->user->format_date($this->dbconfig['introduciator_install_date']),
		));
	}
}
