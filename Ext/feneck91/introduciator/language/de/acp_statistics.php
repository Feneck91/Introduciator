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
 * Mode: statistics
 * Info: language keys are prefixed with 'INTRODUCIATOR_ST_' for 'INTRODUCIATOR_STATISTICS_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_ST_TITLE'						=> 'Statistiken und Überprüfungen über die Vorstellung der Benutzer',
	'INTRODUCIATOR_ST_TITLE_EXPLAIN'				=> 'Wird zur Anzeige von Datenbankinformationen verwendet:
														<ul>
														<li>Die Statistik über Vorstellungen.</li>
														<li>Die Überprüfung der Konsistenz der Datenbank über die Vorstellung des Benutzers (Überprüfung, ob Benutzer mehr als eine Vorstellung veröffentlicht haben).</li>
														</ul>',

	// Number of introduce's texts
	'INTRODUCIATOR_ST_MAIN_STATISTICS_TITLE'		=> 'Allgemeine Statistik',
	'INTRODUCIATOR_ST_NB_INTRODUCTION_TITLE'		=> 'Anzahl der Vorstellung im Forum:',

	// Array's texts
	'INTRODUCIATOR_ST_ARRAY_TITLE'					=> 'Diese Tabelle zeigt alle Vorstellungen an, die mehr als einmal veröffentlicht wurden.',
	'INTRODUCIATOR_ST_ARRAY_NO_MULTIPLE_DETECTED'	=> 'Keine mehrfachen Vorstellungen erkannt',
	'INTRODUCIATOR_ST_ARRAY_HEADER_USER'			=> 'Benutzer',
	'INTRODUCIATOR_ST_ARRAY_HEADER_DATE'			=> 'Datum',
	'INTRODUCIATOR_ST_ARRAY_HEADER_INTRODUCE'		=> 'Vorstellungen',

	// Errors
	'INTRODUCIATOR_ST_NOT_ENABLED_FOR_STATISTICS'	=> 'Um Statistiken zu erhalten, solltest du die Introduciator-Erweiterung aktivieren und konfigurieren!',

	// Buttons
	'INTRODUCIATOR_ST_CHECK'						=> 'Überprüfen',
));
