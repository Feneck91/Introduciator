<?php
/**
 * ext_enable_error.php [Italian]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
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
	$lang = [];
}

$lang = array_merge($lang, [
	'INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION' => 'Introduciator richiede phpBB 3.2.8 o successivo.',
	'INTRODUCIATOR_ENABLE_ERROR_STORE'         => 'Introduciator non è riuscito a creare <strong>%s</strong> né a scrivere al suo interno. Questa cartella è necessaria per impedire agli utenti di pubblicare più di una presentazione; rendila scrivibile dal server web prima di attivare l\'estensione.',
	'INTRODUCIATOR_STORE_NOT_WRITABLE'         => 'Introduciator non riesce a scrivere in <strong>%s</strong>. La protezione contro le presentazioni duplicate è attualmente disattivata. Rendi questa cartella scrivibile dal server web per riattivarla.',
]);
