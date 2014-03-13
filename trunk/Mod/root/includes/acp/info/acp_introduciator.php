<?php
/**
*
* @package Diary MOD
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

/**
* @package module_install
*
* Documentation : https://wiki.phpbb.com/Mcp/info
*/
class acp_diary_info
{
	function module()
	{
		return array(
			'filename'			=> 'acp_diary',		// Filename : includes/acp/acp_diary.php (the name of the file this info file is used for)
			'version'			=> '0.0.1-Dev',		// Version
			'modes'		=> array(
				'general'			=> array('title' => 'DIARY_GENERAL',		'auth' => 'acl_a_diady_manage', 'cat' => array('ACP_DIARY_MOD')),
				'configuration'		=> array('title' => 'DIARY_CONFIGURATION',	'auth' => 'acl_a_diady_manage', 'cat' => array('ACP_DIARY_MOD')),
				'events_types'		=> array('title' => 'DIARY_EVENTS_TYPES',	'auth' => 'acl_a_diady_manage', 'cat' => array('ACP_DIARY_MOD')),
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