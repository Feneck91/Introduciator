<?php
/**
 * info_acp_introduciator.php [Italian]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) Traduzione MOD by Galandas (Rey) 2016 www.phpbb3world.altervista.org/
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
 * Mode: general
 * Info: language keys are prefixed with 'INTRODUCIATOR_GP_' for 'INTRODUCIATOR_GENERAL_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_GP_TITLE'							=> 'Informazioni Generali',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'					=> 'Ottieni la versione di questa MOD.',

	// Extension's informations
	'INTRODUCIATOR_GP_INFOS_ARRAY_HEADER_INFORMATIONS'	=> '??Informations',
	'INTRODUCIATOR_GP_INFOS_ARRAY_HEADER_VALUES'		=> '??Values',
	'INTRODUCIATOR_GP_INFOS'							=> '??informations Introduzione',
	'INTRODUCIATOR_GP_INSTALL_DATE'						=> 'Data Installazione <strong>Introduzione</strong> MOD:',
	'INTRODUCIATOR_GP_VERSION'							=> '<strong>Introduzione</strong> Versione MOD:',
	'INTRODUCIATOR_GP_DETAILS'							=> 'xxxxxxx',
	'INTRODUCIATOR_GP_URL_DETAILS'						=> 'https://www.phpbb.com/customise/db/extension/introduciator/',
));
