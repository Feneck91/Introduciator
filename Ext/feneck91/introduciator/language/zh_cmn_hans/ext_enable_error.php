<?php
/**
 * ext_enable_error.php [Simplified Chinese]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @Simplified Chinese Language (c) David Yin <https://www.phpbbchinese.com>
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
	'INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION' => 'Introduciator 需要 phpBB 3.2.8 或更高版本。',
	'INTRODUCIATOR_ENABLE_ERROR_STORE'         => 'Introduciator 无法创建 <strong>%s</strong>，也无法向其写入。该目录用于防止用户发表多篇自我介绍；请在启用本扩展之前，将其设置为 Web 服务器可写。',
	'INTRODUCIATOR_STORE_NOT_WRITABLE'         => 'Introduciator 无法写入 <strong>%s</strong>。防止重复自我介绍的保护目前已停用。请将该目录设置为 Web 服务器可写，以重新启用该保护。',
]);
