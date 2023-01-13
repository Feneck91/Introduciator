<?php
/**
 * introduciator.php [English]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
 * General messages
 */
$lang = array_merge($lang, array(
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'			=> 'Your introduction message is pending approval, please wait.',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'	=> 'During the approval of your introduction message, only the editing is allowed.',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'				=> 'You are not allowed to introduce yourself more than once!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'			=> 'You are not allowed to delete the first post of your introduction!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'				=> 'You are not allowed to delete the first post of this introduction! You can delete this introduction by deleting the topic.',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'				=> 'Please introduce youself into the topic: %s',
	'INTRODUCIATOR_EXT_DISABLED'								=> 'The Introduciator Extension is disabled. You should enable it to make this Extension workable.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'					=> '<strong>To be able to post, <u>you must</u> introduce yourself</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'					=> 'As for every new user, you must introduce yourself to other members in the “<a href="%s">%s</a>” forum<br />
																	Only a new topic in the forum for introductions is allowed.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES'				=> '<br />
																	When creating the introduction topic, please observe the following rules that are also displayed at the top of the forum for introductions.',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'						=> '<strong><u>The rules are repeated here:</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM'					=> 'Go to the “%s” forum',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM'					=> 'Introduce yourself',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'					=> '<br />During presentation approval, it remains editable and moderators can reply to you.
																	<br />This will allow you to bring it into conformity with the requirements of the forum if necessary.',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'							=> 'Member’s introduction',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'					=> 'No introduction available for this membrer',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'						=> 'See the member’s introduction',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'			=> 'The introduction of this member is pending approval',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'							=> 'Go to member’s introduction',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'							=> 'The member’s introduction is pending approval',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'							=> 'No introduction available for this member',
));
