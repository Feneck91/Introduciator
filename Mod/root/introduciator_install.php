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
define('UMIL_AUTO', true);  // Must run define('UMIL_AUTO', true) before calling umil_auto.php else it don't work.
define('IN_PHPBB', true);   // Protect subfoder files to direct access

// Include common php file, in the root of the phpbb forum
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Check if UMIL is installed or not
if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'INTRODUCIATOR_MOD';

// The name of the config variable which will hold the currently installed version
// UMIL will handle checking, setting, and updating the version itself.
$version_config_name = 'introduciator_mod_version';	// <-- includes/acp/acp_introduciator.php and here : change $versions

// The language file which will be included when installing
$language_file = 'mods/introduciator';

// logo image
$logo_img = 'images/introduciator/introduciator_logo_small.png';

// UMIL variables
// $mod_name The name of the mod to be displayed during installation.
// $language_file The language file which will be included when installing (should contain the $mod_name)
// $version_config_name The name of the config variable which will hold the currently installed version
// $versions The array of versions and actions within each name of the mod

//
// Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
// $phpbb_root_path will get prepended to the path specified
// Image height should be 50px to prevent cut-off or stretching.
//$logo_img = 'images/introduciator/introduciator_logo_small.png';

// Current time needed for 'introduciator_install_date'
$current_time = time();

// Options to display to the user
$options = array(
	'legend2'	=> 'WARNING',
	'welcome'	=> array(
		'lang' => 'INSTALL_INTRODUCIATOR_MOD_WELCOME',
		'type' => 'custom',
		'function' => 'display_message',
		'params' => array('INSTALL_INTRODUCIATOR_MOD_WELCOME_NOTES', 'error'),
		'explain' => false),
	'legend3'	=> 'ACP_SUBMIT_CHANGES',
);

// The array of versions and actions within each.
// You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
//
// You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
// The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
$versions = array(
	'1.1.0' => array(
		// Remove old config entry
		'config_remove' => array(
			array('allow_introduciator'),
		),
		'config_add' => array(
			array('introduciator_explanation_message_title_uid',					''),
			array('introduciator_explanation_message_title_bitfield',				''),
			array('introduciator_explanation_message_title_bbcode_options',			''),
			array('introduciator_explanation_message_text_uid',						''),
			array('introduciator_explanation_message_text_bitfield',				''),
			array('introduciator_explanation_message_text_bbcode_options',			''),
			array('introduciator_explanation_message_rules_title_uid',				''),
			array('introduciator_explanation_message_rules_title_bitfield',			''),
			array('introduciator_explanation_message_rules_title_bbcode_options',	''),
			array('introduciator_explanation_message_rules_text_uid',				''),
			array('introduciator_explanation_message_rules_text_bitfield',			''),
			array('introduciator_explanation_message_rules_text_bbcode_options',	''),
		),
	),

	'1.0.0' => array(
		//-------------------------------------------------------------
		// Add new permission to module
		//-------------------------------------------------------------
		// Now to add some permission settings
		'permission_add' => array(
			array('a_introduciator_manage', true),
			array('u_must_introduce', true),
		),

		// Global Role permissions for user mask : Yes to All
		'permission_set' => array(
			array('ROLE_USER_STANDARD',		'u_must_introduce'),
			array('ROLE_USER_LIMITED',		'u_must_introduce'),
			array('ROLE_USER_NEW_MEMBER',	'u_must_introduce'),
		),

		// Add new permission
		//-------------------------------------------------------------
		// Add the module in ACP under the .MOD tab
		'module_add' => array(
			// ACP_CAT_DOT_MODS is '.MOD' in acp
			array('acp', 'ACP_CAT_DOT_MODS', 'ACP_INTRODUCIATOR_MOD'),

			//---------------------------------------------------------------------
			// Creation of ACP sub caterories under Introduciator mod into .MOD tab

			// Add Sub category 'General' into the ACP .MOD tab / Under ACP_INTRODUCIATOR_MOD
			array('acp', 'ACP_INTRODUCIATOR_MOD', array(
				'module_basename'	=> 'introduciator',
				'module_langname'	=> 'INTRODUCIATOR_GENERAL',
				'module_mode'		=> 'general',
				'module_auth'		=> 'acl_a_introduciator_manage',	// Own permission
				),
			),

			// Add Sub category 'Configuration' into the ACP .MOD tab / Under ACP_INTRODUCIATOR_MOD
			array('acp', 'ACP_INTRODUCIATOR_MOD', array(
				'module_basename'	=> 'introduciator',
				'module_langname'	=> 'INTRODUCIATOR_CONFIGURATION',
				'module_mode'		=> 'configuration',
				'module_auth'		=> 'acl_a_introduciator_manage',	// Own permission
				'after'				=> 'INTRODUCIATOR_GENERAL',
				),
			),

			// Creation of ACP sub caterories under Introduciator mod into .MOD tab
			//---------------------------------------------------------------------
		),
		'config_add' => array(
			array('introduciator_install_date', $current_time),
			array('allow_introduciator', '0'),
			array('introduciator_allow', '0'),
			array('introduciator_fk_forum_id',						0),
			array('introduciator_is_check_delete_first_post',		true),
			array('introduciator_is_explanation_enabled',			false),
			array('introduciator_is_use_permissions',				true),
			array('introduciator_is_include_groups',				true),
			array('introduciator_ignored_users',					''),
			array('introduciator_explanation_message_title',		'%explanation_title%'),
			array('introduciator_explanation_message_text',			'%explanation_text%'),
			array('introduciator_is_explanation_display_rules',		true),
			array('introduciator_explanation_message_rules_title',	'%rules_title%'),
			array('introduciator_explanation_message_rules_text',	'%rules_text%'),
		),

		// Add Groups list table
		'table_add' => array(
			array(INTRODUCIATOR_GROUPS_TABLE, array(
				'COLUMNS' => array(
					'fk_group'			=> array('UINT', NULL),
				),
			)),
		),

		// Purge cache else
		'cache_purge' => '',
	),
);

// Include the UMIL Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

/**
* Display a message with a specified css class
*
* @param string		$lang_string	The language string to display
* @param string		$class			The css class to apply
* @return string					Formated html code
*/
function display_message($lang_string, $class)
{
	global $user;

	return '<span class="' . $class . '">' . $user->lang[$lang_string] . '</span>';
}