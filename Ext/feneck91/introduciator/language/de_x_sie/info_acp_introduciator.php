<?php

/**
 * info_acp_introduciator.php [German honorifics]
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
 * mode: main : the name of the extension
 */
$lang = array_merge($lang, array(
	'ACP_INTRODUCIATOR_EXTENSION'					=> 'Introduciator',

	/**
	 * Titles present on the left side of Extensions ACP's tab under Introduciator item
	 */
	'INTRODUCIATOR_GENERAL'							=> 'Allgemein',
	'INTRODUCIATOR_CONFIGURATION'					=> 'Konfiguration',
	'INTRODUCIATOR_EXPLANATION'						=> 'Erklärungen',
	'INTRODUCIATOR_STATISCICS'						=> 'Statistiken',
));
