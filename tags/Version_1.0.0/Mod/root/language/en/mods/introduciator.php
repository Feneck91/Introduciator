<?php
/**
*
* introduciator.php [English]
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

/*
* UMIL : These string are used when introduciator MOD is installed
*/
$lang = array_merge($lang, array(
	'INSTALL_INTRODUCIATOR_MOD'					=> 'Install Introduciator Mod',

	'INSTALL_INTRODUCIATOR_MOD_CONFIRM'			=> 'Are you ready to install the Introduciator Mod?',

	'INSTALL_INTRODUCIATOR_MOD_WELCOME'			=> 'Information',
	'INSTALL_INTRODUCIATOR_MOD_WELCOME_NOTES'	=> 'By default, this MOD is not enabled, you should enable and configure it in <strong>ACP &gt;&gt; .MODS &gt;&gt; Introduciator &gt;&gt; Configuration</strong>.
													<br/>Do not forget to set up the new permission <strong>Must introduce himself</strong> in the ACP &gt;&gt; « User permissions »',

	'INTRODUCIATOR_MOD'							=> 'Introduciator Mod',
	'INTRODUCIATOR_MOD_EXPLAIN'					=> 'Install Introduciator Mod database changes with UMIL auto method.',

	'UNINSTALL_INTRODUCIATOR_MOD'				=> 'Uninstall Introduciator Mod',
	'UNINSTALL_INTRODUCIATOR_MOD_CONFIRM'		=> 'Are you ready to uninstall the Introduciator Mod? All settings and data saved by this mod will be removed!',

	'UPDATE_INTRODUCIATOR_MOD'					=> 'Update Introduciator Mod',
	'UPDATE_INTRODUCIATOR_MOD_CONFIRM'			=> 'Are you ready to update the Introduciator Mod?',

	'UNUSED_LANG_FILES_TRUE'					=> 'Removal of unused language files.',
	'UNUSED_LANG_FILES_FALSE'					=> 'The removal of unused files is not necessary.',
));

/*
* Other : Messages
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_MOD_INTRODUCE_WAITING_APPROBATION'	=> 'Your introduction message is pending approval, please wait.',
	'INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'		=> 'You are not allowed to introduce yourself more than once!',
	'INTRODUCIATOR_MOD_DELETE_INTRODUCE_MY_FIRST_POST'	=> 'You are not allowed to delete the first post of your introduction!',
	'INTRODUCIATOR_MOD_DELETE_INTRODUCE_FIRST_POST'		=> 'You are not allowed to delete the first post of this introduction! You can delete this introduction by deleting the topic.',
	'INTRODUCIATOR_MOD_MUST_INTRODUCE_INTO_FORUM'		=> 'Please introduce youself into the topic: %s',
	'INTRODUCIATOR_MOD_DISABLED'						=> 'The Introduciator MOD is disabled. You should enable it to make this MOD workable.',
	'INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TITLE'			=> '<strong>To be able to post, <u>you must</u> introduce yourself</strong>',
	'INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TEXT'			=> 'As for every new user, you must introduce yourself to other members in the “<a href="%forum_url%">%forum_name%</a>” forum<br/>
															Only a new topic in the forum for introductions is allowed.<br/>
															When creating the introduction topic, please observe the following rules that are also displayed at the top of the forum for introductions.',
	'INTRODUCIATOR_MOD_DEFAULT_RULES_TITLE'				=> '<strong><u>The rules are repeated here:</u></strong>',
	'INTRODUCIATOR_MOD_DEFAULT_LINK_GOTO_FORUM'			=> '<a href="%forum_url%">Go to the “%forum_name%” forum now by clicking on this link</a>',
	'INTRODUCIATOR_MOD_DEFAULT_LINK_POST_FORUM'			=> '<a href="%forum_post%">Introduce yourself now by clicking on this link</a>',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'					=> 'Member’s introduction',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'			=> 'No introduction avalaible for this membrer',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'				=> 'See the member’s introduction',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'	=> 'The introduction of this member is pending approval',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'					=> 'Go to member’s introduction',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'					=> 'The member’s introduction is pending approval',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'					=> 'No introduction avalaible for this member',
));

?>