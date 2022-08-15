<?php

/**
 * info_acp_introduciator.php [German]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @German Language (c) Dr.Death  <http://www.lpi-clan.de>
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
 * mode: explanation
 * Info: language keys are prefixed with 'INTRODUCIATOR_EP_' for 'INTRODUCIATOR_EXPLANATION_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_EP_TITLE'										=> 'Introduciator Erklärung der Seiteneinstellungen',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'								=> 'Erlaubt die Konfiguration der Seiteneinstellungen des Introduciator’s',

	// Settings: page configuration
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'						=> 'Erklärungen zur Seitenkonfiguration',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'									=> 'Seite mit Erklärungen anzeigen:',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'							=> 'Diese Option wird verwendet, um eine Erklärungsseite anzuzeigen, wenn der Benutzer versucht, in ein anderes Forum als das Forum für Einführungen zu posten.',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'						=> 'Anzeige der Regeln des Forums für Vorstellungen:',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'				=> 'Wird verwendet, um die Regeln für das Forum für Vorstellungen auf der Erklärungsseite anzuzeigen.',

	// Settings: page text configuration
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'					=> 'Erklärungen zur Konfiguration der Textseite',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN'			=> 'Für alle nachfolgenden Felder sind folgende Funktionen verfügbar:<br/>
																		<ul>
																		<li><b>%forum_name%</b>: Name des Forums für Vorstellungen</li>
																		<li><b>%forum_url%</b>: URL zum Forum für Vorstellungen.</li>
																		<li><b>%forum_post%</b>: URL um neue Beiträge in das Forum für Vorstellungen zu posten.</li>
																		</ul>
																		Zur Erstellung von Nachrichten kann man BBcodes verwenden.<br/>
																		<br/>
																		<u>Beispiele:</u>
																		<ul>
																		<li>Link zum Forum für Vorstellungen erstellen: <i>[url=<b>%forum_url%</b>]Hier klicken, um zum Forum ’<b>%forum_name%</b> zu gelangen’[/url]</i>
																		<li>Link erzeugen, um ein Thema in einem Forum für Vorstellungen zu erstellen: <i>[url=<b>%forum_post%</b>]Hier klicken um ein neues Thema im Forum ’<b>%forum_name%</b> zu erstellen’[/url]</i>
																		</ul>
																		<br/>',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'								=> 'Erläuterung Seitentitel:',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'						=> 'Standard = <b>%explanation_title%</b><br/>Du kannst diesen Text mit deinem eigenen ersetzen.',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'									=> 'Text der Erklärungsseite:',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'							=> 'Standard = <b>%explanation_text%</b><br/>Du kannst diesen Text mit deinem eigenen ersetzen.',
	'INTRODUCIATOR_EP_RULES_TITLE'									=> 'Erläuterung der Regeln Titel:',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'							=> 'Standard = <b>%rules_title%</b><br/>Du kannst diesen Text mit deinem eigenen ersetzen.',
	'INTRODUCIATOR_EP_RULES_TEXT'									=> 'Text der Regeln für das Forum der Vorstellungen:',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'							=> 'Standard = <b>%rules_text%</b><br/>Standardmäßig wird %rules_text% durch die Regeln für das Forum für Vorstellungen ersetzt.<br/>Du kannst diesen Text mit deinem eigenen ersetzen.',

	// Logs
	'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED'						=> '<strong>Introduciator: Die Einstellungen der Erklärung wurden aktualisiert.</strong>',

	// Confirm box
	'INTRODUCIATOR_EP_UPDATED'										=> 'Die Einstellungen der Erklärungsseite wurden aktualisiert.',
));
