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
 * Class to manage general acp page.
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
	 * Constructor
	 *
	 * @param string    $php_ext          phpBB Extention
	 * @param language  $language         Language user object
	 * @param request   $request          Request object
	 * @param template	$template         Template object
	 * @param user      $user             User object
	 * @param db        $dbconfig         Config object
	 *
	 * @access public
	 */
	public function __construct($php_ext, language $language, request $request, template $template, user $user, db $dbconfig)
	{
		parent::__construct(
			//null,        // helper
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
	 * Manage the page.
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
		global $phpbb_admin_path;

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
				'S_INTRODUCIATOR_VERSION_UP_TO_DATE'	=> phpbb_version_compare(trim($latest_version_info[0]), $this->dbconfig['introduciator_extension_version'], '<='),
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
			'INTRODUCIATOR_VERSION'					=> $this->dbconfig['introduciator_extension_version'],
			// Install date of this extension
			'INTRODUCIATOR_INSTALL_DATE'			=> $this->user->format_date($this->dbconfig['introduciator_install_date']),

			// Check force URL
			// i is the ID of this extension's module (-feneck91-introduciator-acp-introduciator_module) / mode is the sub item
			'U_INTRODUCIATOR_VERSIONCHECK_FORCE'	=> append_sid("{$phpbb_admin_path}index.{$this->php_ext}", 'i=-feneck91-introduciator-acp-introduciator_module&amp;mode=' . $mode . '&amp;introduciator_versioncheck_force=1'),
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
		global $cache;

		$info = $cache->get('introduciator_version_check');

		if ($info === false || $force_update)
		{
			$errstr = '';
			$errno = 0;

			$info = get_remote_file(acp_general_controller::url_version_check, acp_general_controller::folder_version_check, acp_general_controller::file_version_check, $errstr, $errno);

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