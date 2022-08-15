<?php

/**
 * info_acp_introduciator.php [German honorifics]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @German Language (c) Dr.Death  <http://www.lpi-clan.de>
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) 2022 Leinad4Mind
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
	$lang = [];
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
$lang = array_merge($lang, [
	// Titles
	'INTRODUCIATOR_CP_TITLE'										=> 'Konfigurationseinstellungen des Introducators',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'								=> 'Hier können Sie die Konfiguration der Extension vornehmen.',

	// Settings: general
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'							=> 'Der Benutzer wird gezwungen, sich vorzustellen:',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN'					=> 'Wenn diese Option aktiviert ist, wird der Benutzer gezwungen, seine eigene Vorstellung zu posten, bevor er in anderen Themen posten darf.
																			<br/>Wenn diese Funktion nicht aktiviert ist, bleiben alle anderen Optionen aktiv.',
	'INTRODUCIATOR_CP_CHECK_DEL_FIRST_POST'							=> 'Die Löschung des ersten Vorstellungsbeitrag im Forum für Vorstellungen wird überprüft:',
	'INTRODUCIATOR_CP_CHECK_DEL_FIRST_POST_EXPLAIN'					=> 'Wenn diese Option aktiviert ist, wird verhindert, dass der erste Beitrag in einem beliebigen Thema im Forum für Vorstellungen gelöscht werden kann.
																			<br/>Selbst Moderatoren oder Administratoren haben dazu keine Berechtigung, um sicher zu sein, dass der erste Beitrag in einem vorstellenden Thema wirklich die Vorstellung eines Forenmitglieds ist. Es ist jedoch weiterhin möglich, das Thema zu löschen, wenn die Berechtigungen dies zulassen.
																			<br/>Sie können diese Option deaktivieren, aber in diesem Fall kann ein Benutzer mehrere Vorstellungen haben. Die Aktivierung dieser Option ist zu empfehlen.',
	'INTRODUCIATOR_CP_FORUM_CHOICE'									=> 'Das Forum, in dem der Benutzer sich vorstellen muss:',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'							=> 'Es wird nur dieses Forum überwacht, ob sich Forenbenutzer vorgestellt haben.',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'						=> 'Genehmigungsoptionen der Vorstellung:',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN'				=> 'Wird verwendet, um eine Vorstellung durch einem Moderator zu genehmigen:<br/>
																			<ul>
																			<li><b>Keine Genehmigung</b>: Die Vorstellung muss nicht genehmigt werden.</li>
																			<li><b>Einfache Genehmigung</b>: Die Vorstellung muss genehmigt werden. Der Benutzer sieht seine Vorstellung nicht, wenn sie nicht von einem Moderator validiert wird (die Standard Vorgehensweise).</li>
																			<li><b>Genehmigung mit Bearbeitung</b>: Die Vorstellung muss genehmigt werden. Der Benutzer kann seine Vorstellung sofort sehen und ändern. Er kann nicht an anderer Stelle posten, solange seine Vorstellung nicht von einem Moderator validiert wurde. Dies ermöglicht es Moderatoren und Benutzern, sich auszutauschen, um Nachrichten vor der Validierung durch einen Moderator in Übereinstimmung mit den Vorgaben zu bringen. Nur die Bearbeitung ist erlaubt. Antworten und Zitieren sind verboten.</li>
																			</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'						=> 'Keine Genehmigung',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'						=> 'Einfache Genehmigung',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'				=> 'Genehmigung mit Bearbeitung',

	// Settings: groups and users
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'		=> 'Konfiguration von Gruppen und Benutzern',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'								=> 'Benuntze phpBB Berechtigungen:',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'						=> 'Sie können entweder die phpBB Berechtigungen oder die folgende Konfiguration (einfachster Weg, aber weniger effizient) verwenden, um anzuzeigen, dass der Benutzer sich vorstellen muss.',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'						=> 'Forenrechte verwenden',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'					=> 'Extension Konfiguration verwenden',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'						=> 'Gruppen einschließen oder ausschließen:',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'				=> 'Wenn "Gruppen einschließen" ausgewählt ist, müssen sich nur die Benutzer ausgewählter Gruppen vorstellen.<br />Wenn "Gruppen ausschließen" ausgewählt wird, müssen sich nur Benutzer, die nicht zu den ausgewählten Gruppen gehören, vorstellen.',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'						=> 'Gruppen einschließen',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'						=> 'Gruppen ausschließen',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'								=> 'Gruppen Auswahl:',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'						=> 'Wählbare Gruppen, die ein- oder ausgeschlossen werden sollen.',
	'INTRODUCIATOR_CP_IGNORED_USERS'								=> 'Ignorierte Benutzer:',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'						=> 'Benutzer, die sich nicht vorstellen müssen.<br /> In jeder Zeile nur einen Benutzernamen eingeben.<br /> Die Option wird z.B. für die Administratoren oder Testkonten verwendet.',

	// Messages
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'					=> 'Keine Forenauswahl',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'					=> 'Sie müssen ein Forum auswählen!',

	// Logs
	'INTRODUCIATOR_CP_LOG_UPDATED'									=> '<strong>Introducators: Konfigurationseinstellungen aktualisiert.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'										=> 'Die Konfiguration wurde aktualisiert',
]);