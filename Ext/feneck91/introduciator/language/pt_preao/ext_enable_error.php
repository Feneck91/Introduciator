<?php

/**
 * @package phpBB Extension - Introduciator Extension for phpBB.
 * ext_enable_error.php [English]
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION' => 'O Introduciator requer o phpBB 3.2.8 ou mais recente.',
	'INTRODUCIATOR_ENABLE_ERROR_STORE'         => 'O Introduciator não conseguiu criar ou escrever em <strong>%s</strong>. Esta pasta é necessária para impedir que os utilizadores publiquem mais do que uma apresentação; torna-a escrevível pelo servidor web antes de activares a extensão.',
	'INTRODUCIATOR_STORE_NOT_WRITABLE'         => 'O Introduciator não consegue escrever em <strong>%s</strong>. A protecção contra apresentações duplicadas está actualmente desactivada. Torna esta pasta escrevível pelo servidor web para a reactivar.',
]);
