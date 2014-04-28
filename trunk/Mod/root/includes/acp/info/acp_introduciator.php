<?php
/**
*
* @package Introduciator MOD
* @author Feneck91 (Stéphane Château) feneck91@free.fr
* @version $Id$
* @copyright (c) 2013 @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $phpbb_root_path,$phpEx;	// Php bb root path / php Extension
require_once($phpbb_root_path . 'includes/functions_introduciator.' . $phpEx);

/**
* @package module_install
*
* Documentation : https://wiki.phpbb.com/Mcp/info
*/
class acp_introduciator_info
{
	function module()
	{
		return array(
			'title'				=> 'ACP_INTRODUCIATOR_MOD',			// Used when going to System / Modules / Admin
			'filename'			=> 'acp_introduciator',				// Filename : includes/acp/acp_introduciator.php (the name of the file this info file is used for)
			'version'			=> INTRODUCIATOR_CURRENT_VERSION,	// Version
			'modes'		=> array(
				'general'			=> array('title' => 'INTRODUCIATOR_GENERAL',		'auth' => 'acl_a_introduciator_manage', 'cat' => array('ACP_INTRODUCIATOR_MOD')),
				'configuration'		=> array('title' => 'INTRODUCIATOR_CONFIGURATION',	'auth' => 'acl_a_introduciator_manage', 'cat' => array('ACP_INTRODUCIATOR_MOD')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>