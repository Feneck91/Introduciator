<?php
/**
 * ext_enable_error.php [English]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
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
	'INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION' => 'Introduciator requires phpBB 3.2.8 or newer.',
	'INTRODUCIATOR_ENABLE_ERROR_STORE'         => 'Introduciator could not create or write to <strong>%s</strong>. This directory is needed to prevent users from posting more than one introduction; please make it writable by the web server before activating the extension.',
	'INTRODUCIATOR_STORE_NOT_WRITABLE'         => 'Introduciator cannot write to <strong>%s</strong>. The protection against duplicate introductions is currently disabled. Make this directory writable by the web server to re-enable it.',
]);
