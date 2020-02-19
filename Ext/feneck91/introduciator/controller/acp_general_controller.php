<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use \feneck91\introduciator\helper\extension_manager_helper;
use \phpbb\language\language;
use \phpbb\request\request;
use \phpbb\template\template;
use \phpbb\user;
use \phpbb\config\db;
use \phpbb\path_helper;
use \phpbb\cache\driver\driver_interface;

/**
 * Class used to manage general acp page.
 *
 * This is the page used to display current version, installed date version and check if new version is avalaible.
 */
class acp_general_controller extends acp_main_controller
{
	/**
	 * URL of web site where download the latest version file info
	 */
	const url_version_check           = 'feneck91.free.fr';

	/**
	 * Folder in web site where download the latest version file info
	 */
	const folder_version_check       = '/phpbb';

	/**
	 * File name to download the latest version file info
	 */
	const file_version_check         = 'introduciator_extension_version.txt';

	/**
	 * @var string The phpBB admin path.
	 */
	/**
	 * @var \feneck91\introduciator\helper\extension_manager_helper Extension manager object
	 */
	protected $ext_manager_helper;

	/**
	 * @var string The phpBB admin path.
	 */
	protected $phpbb_admin_path;

	/**
	 * @var \phpbb\cache\driver\driver_interface Manage cache object
	 */
	protected $cache;

	/**
	 * Constructor
	 *
	 * @param \feneck91\introduciator\helper\extension_manager_helper       $ext_manager_helper         Extension manager object
	 * @param string                                                        $php_ext                    phpBB Extention
	 * @param \phpbb\language\language                                      $language                   Language user object
	 * @param \phpbb\request\request                                        $request                    Request object
	 * @param \phpbb\template\template                                      $template                   Template object
	 * @param \phpbb\user                                                   $user                       User object
	 * @param \phpbb\config\db                                              $dbconfig                   Config object
	 * @param \phpbb\path_helper                                            $path_helper                Path helper to get admin path
	 * @param \phpbb\cache\driver\driver_interface                          $cache                      Cache
	 *
	 * @access public
	 */
	public function __construct(extension_manager_helper $ext_manager_helper, $php_ext, language $language, request $request, template $template, user $user, db $dbconfig, path_helper $path_helper, driver_interface $cache)
	{
		$this->ext_manager_helper = $ext_manager_helper;
		$this->phpbb_admin_path = $path_helper->get_phpbb_root_path() . $path_helper->get_adm_relative_path();
		$this->cache = $cache;

		parent::__construct(
			null,        // table prefix
			null,        // root path
			$php_ext,
			$language,
			$request,
			$template,
			$user,
			$dbconfig
		);
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
				'S_INTRODUCIATOR_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $ext_meta['version'], '<='),
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
			'INTRODUCIATOR_VERSION'					=> $ext_meta['version'],
			// Install date of this extension
			'INTRODUCIATOR_INSTALL_DATE'			=> $this->user->format_date($this->dbconfig['introduciator_install_date']),

			// Check force URL
			// i is the ID of this extension's module (-feneck91-introduciator-acp-introduciator_module) / mode is the sub item
			'U_INTRODUCIATOR_VERSIONCHECK_FORCE'	=> append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", 'i=-feneck91-introduciator-acp-introduciator_module&amp;mode=' . $mode . '&amp;introduciator_versioncheck_force=1'),
			'U_ACTION'								=> $this->u_action,
		));
	}

	/**
	 * Obtains the latest version information.
	 *
	 * Return Version info on success, false on failure.
	 *
	 * @param bool $force_update Ignores cached data. Defaults to false.
	 * @param int $ttl Cache version information for $ttl seconds. Defaults to 86400 (24 hours).
	 *
	 * @return string boolean
	 */
	function obtain_latest_version_info($force_update = false, $ttl = 86400)
	{
		$info = $this->cache->get('introduciator_version_check');

		if ($info === false || $force_update)
		{
			$errstr = '';
			$errno = 0;

			$info = get_remote_file(acp_general_controller::url_version_check, acp_general_controller::folder_version_check, acp_general_controller::file_version_check, $errstr, $errno);

			if ($info === false)
			{
				$this->cache->destroy('introduciator_version_check');
				return false;
			}

			$this->cache->put('introduciator_version_check', $info, $ttl);
		}

		return $info;
	}

	/**
	 * Get the update information string from text loaded from update web site.
	 *
	 * The language is written at the beginning of each lines, like [en] ou [fr].
	 * Returns an array with:
	 *   [0] The string into the correct language. English if the current language is not found. Error message if default language was not found
	 *   [1] Indicate if the string (default or not) was found or not (true / false).
	 *
	 * @param string $tag the tag to found. Searching [$tag{language name}] at the beginning of the line.
	 * @param array $latest_version_info Array of string, the informations begins at line 2.
	 * @return array
	 */
	function get_update_information($tag, $latest_version_info)
	{
		$information = $this->language->lang('INTRODUCIATOR_CP_MSG_NO_UPDATE_INFO_FOUND');
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