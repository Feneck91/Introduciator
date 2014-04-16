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
include($phpbb_root_path . 'includes/functions_introduciator.' . $phpEx); // For defines

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
$language_file = 'mods/info_acp_introduciator';

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

// Name of the config variable
$version_config_name = 'introduciator_mod_version';

// Language file which will be included when installing
$language_file = 'mods/introduciator';

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
	'1.0.0-RC2' => array(
		'table_column_add' => array(
			array(INTRODUCIATOR_CONFIG_TABLE, 'is_use_permissions',	array('BOOL',1)),
			array(INTRODUCIATOR_CONFIG_TABLE, 'is_include_groups',	array('BOOL',1)),
			array(INTRODUCIATOR_CONFIG_TABLE, 'fk_forum_id',		array('UINT', NULL)),// Foreign key on FORUMS_TABLE primary key
			array(INTRODUCIATOR_CONFIG_TABLE, 'ignored_users',		array('TEXT_UNI', '')),// Users list
		),
		// Groups list
		'table_add' => array(
			array(INTRODUCIATOR_GROUPS_TABLE, array(
				'COLUMNS' => array(
					'fk_group'			=> array('UINT', NULL),
				),
			)),
		),
	),

	'1.0.0-RC1' => array(
		// Add new config entry
		'config_add' => array(
			array('introduciator_install_date', $current_time),
			array('allow_introduciator', '1', 0),
		),

		// Now to add some permission settings
		'permission_add' => array(
			array('u_must_introduce', true),
		),

		// Global Role permissions for user mask : No to All, Never for Admin and Guest
		'permission_set' => array(
			array('ROLE_USER_STANDARD',		'u_must_introduce'),
			array('ROLE_USER_LIMITED',		'u_must_introduce'),
			array('ROLE_USER_NEW_MEMBER',	'u_must_introduce'),
		),
		//-------------------------------------------------------------
		// Add the module in ACP under the .MOD tab
		'module_add' => array(
			// ACP_CAT_DOT_MODS is '.MOD' in acp
			array('acp', 'ACP_CAT_DOT_MODS', array(
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				// ACP_INTRODUCIATOR_MOD is the name of the MOD
				'module_langname'	=> 'ACP_INTRODUCIATOR_MOD',
				'module_auth'		=> 'acl_a_board',	// Acl Admin Introduciator Manage
				),
			),

			//---------------------------------------------------------------------
			// Creation of ACP sub caterories under Introduciator mod into .MOD tab

			// Add Sub category 'General' into the ACP .MOD tab / Under ACP_INTRODUCIATOR_MOD
			array('acp', 'ACP_INTRODUCIATOR_MOD', array(
				'module_basename'	=> 'introduciator',
				'module_langname'	=> 'INTRODUCIATOR_GENERAL',
				'module_mode'		=> 'general',
				'module_auth'		=> 'acl_a_board',	// Acl Admin Introduciator Manage
				),
			),

			// Add Sub category 'Configuration' into the ACP .MOD tab / Under ACP_INTRODUCIATOR_MOD
			array('acp', 'ACP_INTRODUCIATOR_MOD', array(
				'module_basename'	=> 'introduciator',
				'module_langname'	=> 'INTRODUCIATOR_CONFIGURATION',
				'module_mode'		=> 'configuration',
				'module_auth'		=> 'acl_a_board',	// Acl Admin Introduciator Manage
				'after'			=> 'INTRODUCIATOR_GENERAL',
				),
			),

			// Creation of ACP sub caterories under Introduciator mod into .MOD tab
			//---------------------------------------------------------------------
		),
		// Add the module in ACP under the .MOD tab
		//-------------------------------------------------------------

		//-------------------------------------------------------------
		// Creating the tables into database

		'table_add' => array(
			// Table used to record introduciator configuration
			//   fk_introduciator_id is a foreign key to INTRODUCIATOR_ITEMS_TABLE primary key
			//   fk_forum_id is a foreign key to FORUMS_TABLE primary key. If is the selected forum where
			//               user must introduce himself.
			array(INTRODUCIATOR_CONFIG_TABLE, array(
				'COLUMNS' => array(
					'introduciator_id'						=> array('UINT', NULL, 'auto_increment'),
					'is_enabled'							=> array('BOOL',0),
					'is_check_delete_first_post_enabled'	=> array('BOOL',0),
					'is_explanation_enabled'				=> array('BOOL',1),
					'fk_forum_id'							=> array('UINT', NULL),		// Foreign key on FORUMS_TABLE primary key
					'explanation_message_title'				=> array('TEXT_UNI', ''),	// Explanation page: title
					'explanation_message_text'				=> array('TEXT_UNI', ''),	// Explanation page: explanation text
					'explanation_display_rules_enabled'		=> array('BOOL',1),
					'explanation_message_rules_title'		=> array('TEXT_UNI', ''),	// Explanation page: title rules
					'explanation_message_rules_text'		=> array('TEXT_UNI', ''),	// Explanation page: rules, let empty to get forum rules
				),
				'PRIMARY_KEY'	=> 'introduciator_id',
			)),
		),
		// Creating the tables into database
		//-------------------------------------------------------------

		//-------------------------------------------------------------
		// Fill config table
		'table_row_insert' => array(
			array(INTRODUCIATOR_CONFIG_TABLE,
				array(
					'introduciator_id'						=> 1,
					'is_enabled'							=> false,
					'is_check_delete_first_post_enabled'	=> true,
					'is_explanation_enabled'				=> false,
					'fk_forum_id'							=> 0,
					'explanation_message_title'				=> '%explanation_title%',	// Explanation page: title
					'explanation_message_text'				=> '%explanation_text%',	// Explanation page: explanation text
					'explanation_display_rules_enabled'		=> true,
					'explanation_message_rules_title'		=> '%rules_title%',			// Explanation page: title rules
					'explanation_message_rules_text'		=> '%rules_text%',			// Explanation page: rule, let empty to get forum rules
				),
			),
		),
		// Creating the tables into database
		//-------------------------------------------------------------

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