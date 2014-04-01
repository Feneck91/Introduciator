<?php
/**
*
* info_acp_introduciator.php [English]
*
* @package Introduciator MOD
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
* Titles present on the left side of .MOD ACP's tab under Introduciator item
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
	// Titles
	'GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'						=> 'Groups and users configuration',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS'								=> 'Explanations page configuration',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS_EXPLAIN'						=> 'For all next fields, you can use:<br/>'
																	.  '<ul>'
																	.  '<li><b>%forum_name%</b> : introduce forum’s name</li>'
																	.  '<li><b>%forum_url%</b> : url to introduce forum</li>'
																	.  '<li><b>%forum_post%</b> : url to write new post into introduce forum</li>'
																	.  '</ul>',
	// Sub titles
	"INTRODUCIATOR_CP_ED_MOD_ACTIVATED"								=> 'Activate MOD',
	"INTRODUCIATOR_CP_ED_MOD_ACTIVATED_EXPLAIN"						=> 'Used to enabled or disabled this MOD',
	"INTRODUCIATOR_CP_ED_CHECK_DELETE_FIRST_POST_ACTIVATED"			=> 'Authorize the MOD to verify the deletion of first presentation post into introduce forum',
	"INTRODUCIATOR_CP_ED__CHECK_DELETE_FIRST_POST_ACTIVATED_EXPLAIN"=> 'When this option is on, the MOD prevents to delete the first post that create the topic into introduce forum'.
																	   '<br/>Even moderators or administrators don’t have this permission to be sure that the first post author is the presentation if this member. However, it remains possible to delete the topic if the permissions allow it.' .
																	   '<br/>You can deactivate this option but it can make strange behaviors : a member could also have several presentations, in this case, the first one is taken into account.',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE'								=> 'Forum choice where the user must to introduce himself',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE_EXPLAIN'						=> 'Is used to know with forum should be tested to know if the user has already made it’s introduction or not',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE'					=> 'Display explanation page',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE_EXPLAIN'			=> 'Used to display an explanation page if the user try to post into another forum that the introduced one',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS'					=> 'Include groups or exclude groups',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'			=> 'When include group is selected, only users of selected groups needs to introduce themself.<br/>When exclude group is selected, only users that are not into selected groups needs to introduce themself',
	'INTRODUCIATOR_CP_ED_INCLUDE_GROUPS_OPTION'						=> 'Include groups',
	'INTRODUCIATOR_CP_ED_EXCLUDE_GROUPS_OPTION'						=> 'Exclude groups',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS'							=> 'Groups selections',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS_EXPLAIN'					=> 'Select groups that are to be included or excluded',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS'								=> 'Ignored users',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS_EXPLAIN'						=> 'Users who are not required to introduce themself.<br/>Enter one user on each line.<br/>Used for the administrators or tests accounts for example',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE'					=> 'Explanation page title',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE_EXPLAIN'			=> 'Default = <b>%explanation_title%</b><br/>You can change this texte to put your own',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT'					=> 'Explanation page text',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT_EXPLAIN'			=> 'Default = <b>%explanation_text%</b><br/>You can change this texte to put your own',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED'			=> 'Display introduce forum rules',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED_EXPLAIN'	=> 'Used to display the introduce forum rules into the explanation page',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE'					=> 'Explanation rules titre',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE_EXPLAIN'			=> 'Default = <b>%rules_title%</b><br/>You can change this texte to put your own',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT'					=> 'Introduce forum rules text',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT_EXPLAIN'			=> 'Default = <b>%rules_text%</b><br/>By default, %rules_text% is replaced by intruduced forum rules.<br/>You can change this texte to put your own',
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