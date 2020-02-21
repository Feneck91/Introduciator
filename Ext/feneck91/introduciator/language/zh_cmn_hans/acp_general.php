<?php
/**
 * info_acp_introduciator.php [English]
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
* mode: general
* Info: language keys are prefixed with 'INTRODUCIATOR_GP_' for 'INTRODUCIATOR_GENERAL_PAGES_'
*/
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_GP_TITLE'							=> '一般信息',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'					=> '获取此扩展的版本信息。',

	// Extension's update message
	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'		=> '你的自我介绍扩展不是最新的。',
	//
	// Extension's informations
	'INTRODUCIATOR_GP_INFOS_ARRAY_HEADER_INFORMATIONS'	=> '信息',
	'INTRODUCIATOR_GP_INFOS_ARRAY_HEADER_VALUES'		=> '值',
	'INTRODUCIATOR_GP_INFOS'							=> '自我介绍扩展的情况',
	'INTRODUCIATOR_GP_INSTALL_DATE'						=> '<strong>自我介绍</strong> 扩展的安装日期：',
	'INTRODUCIATOR_GP_VERSION'							=> '<strong>自我介绍</strong> 扩展版本号：',
	'INTRODUCIATOR_GP_UPDATE_VERSION_TITLE'				=> '最新版本：',
	'INTRODUCIATOR_GP_UPDATE_URL_TITLE'					=> '下载链接：',
	'INTRODUCIATOR_GP_UPDATE_INFOS_TITLE'				=> '更新信息：',
));
