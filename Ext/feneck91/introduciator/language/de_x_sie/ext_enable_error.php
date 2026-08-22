<?php
/**
 * ext_enable_error.php [German honorifics]
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
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION' => 'Introduciator benötigt phpBB 3.2.8 oder neuer.',
	'INTRODUCIATOR_ENABLE_ERROR_STORE'         => 'Introduciator konnte <strong>%s</strong> nicht anlegen oder darin schreiben. Dieses Verzeichnis wird benötigt, um zu verhindern, dass Benutzer mehr als eine Vorstellung schreiben. Bitte machen Sie es für den Webserver beschreibbar, bevor Sie die Erweiterung aktivieren.',
	'INTRODUCIATOR_STORE_NOT_WRITABLE'         => 'Introduciator kann nicht in <strong>%s</strong> schreiben. Der Schutz vor doppelten Vorstellungen ist derzeit deaktiviert. Machen Sie dieses Verzeichnis für den Webserver beschreibbar, um ihn wieder zu aktivieren.',
]);
