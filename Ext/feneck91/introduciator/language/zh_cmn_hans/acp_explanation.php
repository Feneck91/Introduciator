<?php
/**
 * info_acp_introduciator.php [English]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @Simplified Chinese Language (c) David Yin <https://www.phpbbchinese.com>
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
 * Mode: explanation
 * Info: language keys are prefixed with 'INTRODUCIATOR_EP_' for 'INTRODUCIATOR_EXPLANATION_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_EP_TITLE'										=> '自我介绍扩展说明的页面设置',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'								=> '允许配置自我介绍扩展的说明页面。',

	// Settings: page configuration
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'						=> '说明页面的配置',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'									=> '显示说明页面：',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'							=> '当用户试图在非自我介绍板块发布帖子的时候，此选项用于显示一个说明页面。',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'						=> '显示自我介绍板块的板块规则：',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'				=> '把自我介绍板块的板块规则显示到说明页面上。',

	// Settings: page text configuration
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'					=> '说明文字页面配置',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN'			=> '下面所有项目，你可以使用：<br/>
																		<ul>
																		<li><b>%forum_name%</b>： 自我介绍板块的名称</li>
																		<li><b>%forum_url%</b>： 自我介绍板块的网址</li>
																		<li><b>%forum_post%</b>： 自我介绍板块的新帖子网址</li>
																		</ul>
																		你可以在消息中使用 BBcodes 。<br/>
																		<br/>
																		<u>比如：</u>
																		<ul>
																		<li>创建链接到自我介绍板块： <i>[url=<b>%forum_url%</b>]点击到自我介绍板块’<b>%forum_name%</b>’[/url]</i>
																		<li>创建链接到自我介绍板块并建立新主题： <i>[url=<b>%forum_post%</b>]点击创建新的自我介绍 ’<b>%forum_name%</b>’[/url]</i>
																		</ul>
																		<br/>',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'								=> '说明页面的标题：',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'						=> '默认是 = <b>%explanation_title%</b><br/>你可以修改这个文字。',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'									=> '说明页面文字：',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'							=> '默认是 = <b>%explanation_text%</b><br/>你可以修改这个文字。',
	'INTRODUCIATOR_EP_RULES_TITLE'									=> '说明规则标题：',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'							=> '默认是 = <b>%rules_title%</b><br/>你可以修改这个文字。',
	'INTRODUCIATOR_EP_RULES_TEXT'									=> '自我介绍板块的版规：',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'							=> '默认是 = <b>%rules_text%</b><br/>默认情况下， %rules_text% 被替换为自我介绍板块的版规。<br/>你可以修改这个文字。',

	// Logs
	'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED'						=> '<strong>自我介绍： 说明页面设置更新。</strong>',

	// Confirm box
	'INTRODUCIATOR_EP_UPDATED'										=> '说明页面的设置已经完成更新',
));
