<?php
/**
*
* info_acp_diary.php [English]
*
* @package Diary MOD
* @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

/**
* mode: main : the name of the MOD
*/
$lang = array_merge($lang, array(
	'ACP_INTRODUCIATOR_MOD'							=> 'Introduciator',
));

/**
* Titles present on the left side of .MOD ACP's tab under Diary item
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_GENERAL'							=> 'General',
	'INTRODUCIATOR_CONFIGURATION'					=> 'Configuration',
));

/**
* mode: general
* Info: language keys are prefixed with 'INTRODUCIATOR_GP_' for 'INTRODUCIATOR_GENERAL_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_GP_TITLE'						=> 'General informations',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'				=> 'Get version of this MOD',

	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Your Introduciator MOD installation is not up to date.',
	'INTRODUCIATOR_GP_STATS'						=> 'Introduciator statistics',
	'INTRODUCIATOR_GP_INSTALL_DATE'					=> 'Install date of <strong>Introduciator</strong> MOD:',
	'INTRODUCIATOR_GP_VERSION'						=> '<strong>Introduciator</strong> MOD version:',
));

/**
* mode: configuration
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_TITLE'						=> 'Introductiator configurations',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'				=> 'Allow to configure the MOD operating',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'				=> 'Allow to select introduced forum, groups that are not needed to be introduced, etc.',
));

/**
* mode: configuration : Edit
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_ED_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
$lang = array_merge($lang, array(
	"INTRODUCIATOR_CP_ED_MOD_ACTIVATED"						=> 'Activate MOD',
	"INTRODUCIATOR_CP_ED_MOD_ACTIVATED_EXPLAIN"				=> 'Used to enabled or disabled this MOD',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE'						=> 'Forum choice where the user must to introduce himself',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE_EXPLAIN'				=> 'Is used to know with forum should be tested to know if the user has already made it\'s introduction or not',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE'			=> 'Display explanation page',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE_EXPLAIN'	=> 'Used to display an explanation page if the user try to post into another forum that the introduced one',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS'			=> 'Include groups or exclude groups',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'	=> 'When include group is selected, only users of selected groups needs to introduce themself.<br/>When exclude group is selected, only users that are not into selected groups needs to introduce themself',
	'INTRODUCIATOR_CP_ED_INCLUDE_GROUPS_OPTION'				=> 'Include groups',
	'INTRODUCIATOR_CP_ED_EXCLUDE_GROUPS_OPTION'				=> 'Exclude groups',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS'					=> 'Groups selections',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS_EXPLAIN'			=> 'Select groups that are to be included or excluded',
));

/**
* Others
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'					=> 'When this MOD is enabled your must choose a forum!',
));

/**
* logs
*/
$lang = array_merge($lang, array(
	//logs
	'LOG_INTRODUCIATOR_UPDATED'				=> '<strong>Introduciator: settings updated.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'				=> 'The configuration has been updated',
));

?>