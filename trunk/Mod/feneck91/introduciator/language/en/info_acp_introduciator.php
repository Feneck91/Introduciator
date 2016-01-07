<?php
/**
*
* info_acp_introduciator.php [English]
*
* @package Introduciator extension
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
* mode: main : the name of the extension
*/
$lang = array_merge($lang, array(
	'ACP_INTRODUCIATOR_EXTENSION'					=> 'Introduciator',

/**
* Titles present on the left side of Extensions ACP's tab under Introduciator item
*/
	'INTRODUCIATOR_GENERAL'							=> 'General',
	'INTRODUCIATOR_CONFIGURATION'					=> 'Configuration',

/**
* mode: general
* Info: language keys are prefixed with 'INTRODUCIATOR_GP_' for 'INTRODUCIATOR_GENERAL_PAGES_'
*/
	'INTRODUCIATOR_GP_TITLE'						=> 'Generals informations',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'				=> 'Get version of this extension.',

	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Your Introduciator extension is not up to date.',
	'INTRODUCIATOR_GP_STATS'						=> 'Introduciator statistics',
	'INTRODUCIATOR_GP_INSTALL_DATE'					=> 'Install date of <strong>Introduciator</strong> extension:',
	'INTRODUCIATOR_GP_VERSION'						=> '<strong>Introduciator</strong> extension version:',
	'INTRODUCIATOR_GP_UPDATE_VERSION_TITLE'			=> 'Latest version:',
	'INTRODUCIATOR_GP_UPDATE_URL_TITLE'				=> 'Download link:',
	'INTRODUCIATOR_GP_UPDATE_INFOS_TITLE'			=> 'Update information:',

/**
* mode: configuration
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
	'INTRODUCIATOR_CP_TITLE'						=> 'Introduciator configuration settings',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'				=> 'Allow to configure the extension settings.',

/**
* mode: configuration : Edit
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_ED_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
	// Titles
	'GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'						=> 'Groups and users configuration',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS'								=> 'Explanations page configuration',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS_EXPLAIN'						=> 'For all next fields, you can use:<br/>
																		<ul>
																		<li><b>%forum_name%</b>: name of the forum for introductions</li>
																		<li><b>%forum_url%</b>: url to the forum for introductions</li>
																		<li><b>%forum_post%</b>: url to write new post into the forum for introductions</li>
																		</ul>
																		You can use BBcodes to make messages.<br/>
																		<br/>
																		<u>Examples:</u>
																		<ul>
																		<li>Make link to forum for introductions: <i>[url=<b>%forum_url%</b>]Click here to go to forum ’<b>%forum_name%</b>’[/url]</i>
																		<li>Make link to create topic into forum for introductions: <i>[url=<b>%forum_post%</b>]Click here to create topic into the forum ’<b>%forum_name%</b>’[/url]</i>
																		</ul>
																		<br/>
																		<strong>All fields are limited to 255 characters!</strong>
																		<br/>
																		<br/>',
	// Sub titles
	'INTRODUCIATOR_CP_ED_EXTENSION_ACTIVATED'						=> 'Enable extension',
	'INTRODUCIATOR_CP_ED_EXTENSION_ACTIVATED_EXPLAIN'				=> 'Used to enable or disable this extension.',
	'INTRODUCIATOR_CP_ED_CHECK_DEL_1ST_POST'						=> 'Authorize the extension to verify the deletion of first introduction post in the forum for introductions',
	'INTRODUCIATOR_CP_ED_CHECK_DEL_1ST_POST_EXPLAIN'				=> 'When this option is on, the extension prevents the first post in any topic in the forum for introductions from deletion.
																		<br/>Even moderators or administrators don’t have this permission to be sure that the first post in any introductive topic is the really the introduction of a forum member. However, it remains possible to delete the topic if the permissions allow it.
																		<br/>You can deactivate this option but in this case a member will be able to have several introductions. Enabling this option is preferable.',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE'								=> 'The forum where the user must introduce himself/herself',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE_EXPLAIN'						=> 'The extension will search only in this forum whether forum users have introduced themselves.',
	'INTRODUCIATOR_CP_ED_POSTING_APPROVAL_LEVEL'					=> 'Introduction approval options',
	'INTRODUCIATOR_CP_ED_POSTING_APPROVAL_LEVEL_EXPLAIN'			=> 'Is used to force introduction to be approved by a moderator:<br/>
																		<ul>
																		<li><b>No approval</b>: don’t force introduction to be approved, let the default processing.</li>
																		<li><b>Simple approval</b>: force introduction to be approved. The user doesn’t see his/her introduction if it is not validated by a moderator (normal processing is used for all messages that use approval).</li>
																		<li><b>Approval with ability to edit</b>: force introduction to be approved. The user can see his/her introduction immediately and can modify it. He/She cannot post elsewhere while his/her introduction is not validated by a moderator. This allows moderators and users to exchange to make messages into compliance before validation by a moderator (unusual message processing approval). Only edition is allowed. Reply and quote are forbiden.</li>
																		</ul>',
	'INTRODUCIATOR_CP_ED_TEXT_POSTING_NO_APPROVAL'					=> 'No approval',
	'INTRODUCIATOR_CP_ED_TEXT_POSTING_APPROVAL'						=> 'Simple approval',
	'INTRODUCIATOR_CP_ED_TEXT_POSTING_APPROVAL_WITH_EDIT'			=> 'Approval with ability to edit',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE'					=> 'Display explanation page',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE_EXPLAIN'			=> 'This option is used to display an explanation page if the user is trying to post into another forum than the forum for introductions.',

	'INTRODUCIATOR_CP_ED_USE_PERMISSIONS'							=> 'Use phpBB permissions',
	'INTRODUCIATOR_CP_ED_USE_PERMISSIONS_EXPLAIN'					=> 'You can use either the phpBB permissions or this extension configuration (simplest way but less efficient) to indicate that the user must introduce himself/herself.<br /><br />When the « Use forum’s permissions » option is used, the next configuration is ignored.',
	'INTRODUCIATOR_CP_ED_USE_PERMISSION_OPTION'						=> 'Use forum’s permissions',
	'INTRODUCIATOR_CP_ED_NOT_USE_PERMISSION_OPTION'					=> 'Use extension configuration',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS'					=> 'Include or exclude groups',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'			=> 'When « include groups » is selected, only users of selected groups need to introduce themselves.<br />When « exclude groups » is selected, only users that are not into selected groups need to introduce themselves.',
	'INTRODUCIATOR_CP_ED_INCLUDE_GROUPS_OPTION'						=> 'Include groups',
	'INTRODUCIATOR_CP_ED_EXCLUDE_GROUPS_OPTION'						=> 'Exclude groups',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS'							=> 'Groups selections',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS_EXPLAIN'					=> 'Select groups that should be included or excluded.',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS'								=> 'Ignored users',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS_EXPLAIN'						=> 'Users who are not required to introduce themselves.<br />Enter one username on each line.<br />The option is used, for example, for the administrators or test accounts.',

	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE'					=> 'Explanation page title',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE_EXPLAIN'			=> 'Default = <b>%explanation_title%</b><br/>You can change this text to your own.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT'					=> 'Explanation page text',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT_EXPLAIN'			=> 'Default = <b>%explanation_text%</b><br/>You can change this text to your own.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED'			=> 'Display rules of the forum for introductions',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED_EXPLAIN'	=> 'Used to display the rules for the forum for introductions on the explanation page.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE'					=> 'Explanation rules title',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE_EXPLAIN'			=> 'Default = <b>%rules_title%</b><br/>You can change this text to your own.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT'					=> 'Text of the rules for the forum for introductions',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT_EXPLAIN'			=> 'Default = <b>%rules_text%</b><br/>By default, %rules_text% is replaced by rules for the forum for introductions.<br/>You can change this text to your own.',

/**
* Others
*/
	'INTRODUCIATOR_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_NO_FORUM_CHOICE_TOOLTIP'					=> 'No forum selection, use it only when the extension is desactivated',
	'INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'					=> 'When this extension is enabled, your should choose a forum!',
	'INTRODUCIATOR_NO_UPDATE_INFO_FOUND'					=> 'No update information available',
	'INTRODUCIATOR_ERROR_TOO_LONG_TEXT'						=> 'Error,  too long text (all texts are limited to 255 characters)',

/**
* logs
*/
	//logs
	'LOG_INTRODUCIATOR_UPDATED'				=> '<strong>Introduciator: settings updated.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'				=> 'The configuration has been updated',
));

?>