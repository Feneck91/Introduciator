<?php

/**
 * info_acp_introduciator.php [English]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
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
 * mode: configuration
 * Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_CP_TITLE'										=> 'Introduciator configuration settings',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'								=> 'Allow to configure the extension settings.',

	// Settings: general
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'							=> 'Force the user to introduce himself:',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN'					=> 'When this option is enabled, the extension force the user to post his own introduce before being allowed to post in other topics.
																			<br/>When this feature is not enabled, all other options remain active.',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST'							=> 'Authorize the extension to verify the deletion of first introduction post in the forum for introductions:',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST_EXPLAIN'					=> 'When this option is on, the extension prevents the first post in any topic in the forum for introductions from deletion.
																			<br/>Even moderators or administrators don’t have this permission to be sure that the first post in any introductive topic is the really the introduction of a forum member. However, it remains possible to delete the topic if the permissions allow it.
																			<br/>You can deactivate this option but in this case a member will be able to have several introductions. Enabling this option is preferable.',
	'INTRODUCIATOR_CP_FORUM_CHOICE'									=> 'The forum where the user must introduce himself/herself:',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'							=> 'The extension will search only in this forum whether forum users have introduced themselves.',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'						=> 'Introduction approval options:',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN'				=> 'Is used to force introduction to be approved by a moderator:<br/>
																			<ul>
																			<li><b>No approval</b>: don’t force introduction to be approved, let the default processing.</li>
																			<li><b>Simple approval</b>: force introduction to be approved. The user doesn’t see his/her introduction if it is not validated by a moderator (normal processing is used for all messages that use approval).</li>
																			<li><b>Approval with ability to edit</b>: force introduction to be approved. The user can see his/her introduction immediately and can modify it. He/She cannot post elsewhere while his/her introduction is not validated by a moderator. This allows moderators and users to exchange to make messages into compliance before validation by a moderator (unusual message processing approval). Only edition is allowed. Reply and quote are forbiden.</li>
																			</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'						=> 'No approval',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'						=> 'Simple approval',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'				=> 'Approval with ability to edit',

	// Settings: groups and users
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'		=> 'Groups and users configuration',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'								=> 'Use phpBB permissions:',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'						=> 'You can use either the phpBB permissions or this extension configuration (simplest way but less efficient) to indicate that the user must introduce himself/herself.',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'						=> 'Use forum’s permissions',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'					=> 'Use extension configuration',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'						=> 'Include or exclude groups:',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'				=> 'When « include groups » is selected, only users of selected groups need to introduce themselves.<br />When « exclude groups » is selected, only users that are not into selected groups need to introduce themselves.',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'						=> 'Include groups',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'						=> 'Exclude groups',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'								=> 'Groups selections:',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'						=> 'Select groups that should be included or excluded.',
	'INTRODUCIATOR_CP_IGNORED_USERS'								=> 'Ignored users:',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'						=> 'Users who are not required to introduce themselves.<br />Enter one username on each line.<br />The option is used, for example, for the administrators or test accounts.',

	// Messages
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'					=> 'No forum selection',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'					=> 'Your must choose a forum!',

	// Logs
	'INTRODUCIATOR_CP_LOG_UPDATED'									=> '<strong>Introduciator: configuration settings updated.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'										=> 'The configuration has been updated',
));