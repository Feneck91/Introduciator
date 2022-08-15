<?php

/**
 * introduciator.php [German honorifics]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @German Language (c) Dr.Death  <http://www.lpi-clan.de>
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

/*
* General messages
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'			=> 'Die Freigabe Ihrer Vorstellung steht noch aus, bitte warte.',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'	=> 'Während der Genehmigung Ihrer Vorstellung ist nur die Bearbeitung erlaubt.',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'				=> 'Sie dürfen sich nicht mehr als einmal vorstellen!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'			=> 'Es ist nicht erlaubt, den ersten Beitrag Ihrer Vorstellung zu löschen!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'				=> 'Es ist nicht erlaubt, den ersten Beitrag dieser Vorstellung zu löschen! Sie können diese Vorstellung löschen, indem Sie das Thema löschen.',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'				=> 'Bitte stellen Sie sich in diesem Thema vor: %s',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'					=> '<strong>Um posten zu können, <u>müssen</u> Sie sich selbst vorstellen</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'					=> 'Wie bei jedem neuen Benutzer müssen Sie sich den anderen Mitgliedern im “<a href="%forum_url%">%forum_name%</a>” Forum vorstellen<br/>
																	Es ist nur <strong>ein</strong> neues Thema im Forum für Vorstellungen erlaubt.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES'				=> '<br/>
																	Bitte beachten Sie die folgenden Regeln bei der Erstellung des Vorstellungsthemas, die auch oben im Forum für Vorstellungen angezeigt werden.',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'						=> '<strong><u>Die Regeln werden hier nochmals wiederholt:</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM'					=> '<a href="%forum_url%">Klicken Sie auf diesen Link um zum Forum “%forum_name%” zu gelangen</a>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM'					=> '<a href="%forum_post%">Stelle Sie sich jetzt vor, indem du auf diesen Link klickst</a>',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'					=> '<br/>Während der Genehmigung der Vorstellung bleibt sie editierbar und die Moderatoren können Ihnen antworten..
																	<br/>Dies ermöglicht es Ihnen, sie gegebenenfalls mit den Anforderungen des Forums in Einklang zu bringen.',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'							=> 'Vorstellung des Benutzers',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'					=> 'Für diesen Benutzer ist keine Vorstellung verfügbar.',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'						=> 'Siehe die Vorstellung des Benutzers',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'			=> 'Die Vorstellung dieses Benutzers ist noch nicht genehmigt.',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'							=> 'Zur Vorstellung des Benutzers',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'							=> 'Die Vorstellung des Benutzers ist noch nicht genehmigt.',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'							=> 'Für diesen Benutzer ist keine Vorstellung verfügbar.',
));