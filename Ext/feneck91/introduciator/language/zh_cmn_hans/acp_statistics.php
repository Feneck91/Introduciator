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
if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
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
 * mode: statistics
 * Info: language keys are prefixed with 'INTRODUCIATOR_ST_' for 'INTRODUCIATOR_STATISTICS_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_ST_TITLE'						=> '用户自我介绍的统计信息和检查',
	'INTRODUCIATOR_ST_TITLE_EXPLAIN'				=> '用于显示数据库信息：
														<ul>
														<li>自我介绍的统计信息。</li>
														<li>用户自我介绍的数据库一致性检查（检查用户是否发布了多个自我介绍）。</li>
														</ul>',

	// Number of introduce's texts
	'INTRODUCIATOR_ST_MAIN_STATISTICS_TITLE'		=> '通用统计',
	'INTRODUCIATOR_ST_NB_INTRODUCTION_TITLE'		=> '有多少个自我介绍：',

	// Array's texts
	'INTRODUCIATOR_ST_ARRAY_TITLE'					=> '这个列表显示有多少个用户发布了超过一次自我介绍的帖子',
	'INTRODUCIATOR_ST_ARRAY_NO_MULTIPLE_DETECTED'	=> '未检测到多个介绍',
	'INTRODUCIATOR_ST_ARRAY_HEADER_USER'			=> '用户',
	'INTRODUCIATOR_ST_ARRAY_HEADER_DATE'			=> '日期',
	'INTRODUCIATOR_ST_ARRAY_HEADER_INTRODUCE'		=> '自我介绍',

	// Buttons
	'INTRODUCIATOR_ST_CHECK'						=> '检查',
));