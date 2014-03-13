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
	'INTRODUCIATOR_GENERAL'					=> 'General',
	'INTRODUCIATOR_CONFIGURATION'			=> 'Configuration',
));

/**
* Language common keys
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_NAME'							=> 'Introduciator name',
));

/**
* mode: general
* Info: language keys are prefixed with 'INTRODUCIATOR_GP_' for 'INTRODUCIATOR_GENERAL_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_GP_TITLE'						=> 'General informations',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'				=> 'Get version of this MOD',

	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Your Diary MOD installation is not up to date.',
	'INTRODUCIATOR_GP_STATS'						=> 'Diary statistics',
	'INTRODUCIATOR_GP_INSTALL_DATE'					=> 'Install date of <strong>Diary</strong> MOD:',
	'INTRODUCIATOR_GP_VERSION'						=> '<strong>Diary</strong> MOD version:',
));

/**
* mode: configuration
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_TITLE'				=> 'Diaries configurations',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'		=> 'Allow to create / delete / edit diaries',
	'INTRODUCIATOR_CP_CREATE_INTRODUCIATOR'			=> 'Create diary',
));

/**
* mode: configuration : Edit
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_ED_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_ED_NAME'						=> 'Diary name',
	'INTRODUCIATOR_CP_ED_NAME_EXPLAIN'				=> 'Is used to give diary name. This name is visible into ACP diaries list',
	'INTRODUCIATOR_CP_ED_TAG'						=> 'Tag',
	'INTRODUCIATOR_CP_ED_TAG_EXPLAIN'				=> 'Tag on 3 characters. All events created by this diary are created with this tag.<br/>This tag is used to share events between several diaries',
	'INTRODUCIATOR_CP_ED_FILTER_TAG'				=> 'Tags filter',
	'INTRODUCIATOR_CP_ED_FILTER_TAG_EXPLAIN'		=> 'Tags filter on 3 characters, one tag on each line.<br/>To make displayed event, it must contains same tags as diary that create it.<br/>It let share events between several diaries',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICES'				=> 'Forums choice where this diary should be displayed',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICES_EXPLAIN'		=> 'Is used to define one or more forums where this diary will be displayed',

	// Root element of forum list
	'INTRODUCIATOR_CP_ED_MAIN_PAGE'					=> 'Welcome page',
	// Associated tooltip
	'INTRODUCIATOR_CP_ED_MAIN_PAGE_TOOLTIP'			=> 'Main forum page',
));

/**
* mode: events_types
* Info: language keys are prefixed with 'INTRODUCIATOR_ETP_' for 'INTRODUCIATOR_EVENTS_TYPES_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_ETP_TITLE'				=> 'Page event type',
	'INTRODUCIATOR_ETP_TITLE_EXPLAIN'		=> 'Explication event type',
));

/**
* Others
*/
$lang = array_merge($lang, array(
	'ERROR_NO_INTRODUCIATOR_ID'					=> 'Diary item is not found!',
	'ERROR_INTRODUCIATOR_NAME_EMPTY'			=> 'The diary name must not be empty!',
	'ERROR_INTRODUCIATOR_ITEM_TAG_INVALID'		=> 'The diary tag must be 3 character length!',
));

/**
* logs
*/
$lang = array_merge($lang, array(
	//logs
	'LOG_INTRODUCIATOR_CONFIGURATION_ITEM'	=> 'Agenda',
	'LOG_INTRODUCIATOR_UPDATED'				=> '<strong>Diary : Settings updated.</strong>',
	'LOG_INTRODUCIATOR_ITEM_ADDED'			=> '<strong>Diary : %1$s added</strong><br />» %2$s',
	'LOG_INTRODUCIATOR_ITEM_UPDATED'		=> '<strong>Diary : %1$s updated</strong><br />» %2$s',
	'LOG_INTRODUCIATOR_ITEM_REMOVED'		=> '<strong>Diary : %1$s deleted</strong>',
	'LOG_INTRODUCIATOR_ITEM_MOVE_DOWN'		=> '<strong>Diary : Moved a %1$s. </strong> %2$s <strong>below</strong> %3$s',
	'LOG_INTRODUCIATOR_ITEM_MOVE_UP'		=> '<strong>Diary : Moved a %1$s. </strong> %2$s <strong>above</strong> %3$s',
));

?>