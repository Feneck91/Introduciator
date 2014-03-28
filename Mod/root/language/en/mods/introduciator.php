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
	'INSTALL_INTRODUCIATOR_MOD_WELCOME'			=> 'Major changes since version %s',

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
	'INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'	=> 'You are not allowed to introduce yourself more than once!',
	'INTRODUCIATOR_MOD_MUST_INTRODUCE_INTO_FORUM'	=> 'Please introduce youself into the topic: %s',
	'INTRODUCIATOR_MOD_DISABLED'					=> 'The Introduciator MOD is disabled. Enable it to use it!',
	'INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TITLE'		=> 'To be able to post, you must <u>you must</u> introduce yourself',
	'INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TEXT'		=> 'For each new user, you must introduce yoursef to other <a href="%forum_url%">“%forum_name%”</a><br/> Forum’s members'
													.  'Only new post into introduce forum is allowed<br/>'
													.  'For the introduce message creation, please follow the following rules that are displayed at the top of the introduce forum',
	'INTRODUCIATOR_MOD_DEFAULT_RULES_TITLE'			=> '<b><u>The rules are repeated here:</u></b>',
	'INTRODUCIATOR_MOD_DEFAULT_LINK_GOTO_FORUM'		=> '<a href="%forum_url%">Go to the “%forum_name%” forum now by clicking on this link</a>',
	'INTRODUCIATOR_MOD_DEFAULT_LINK_POST_FORUM'		=> '<a href="%forum_post%">Introduce yourself now by clicking on this link</a>',
));

?>