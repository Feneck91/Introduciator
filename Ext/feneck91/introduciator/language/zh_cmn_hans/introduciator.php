<?php
/**
 * introduciator.php [English]
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

/*
* General messages
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'			=> '你的自我介绍消息还未审核，请稍后。',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'	=> '在等待审核阶段，只允许编辑自我介绍。',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'				=> '你不可以自我介绍一次以上！',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'			=> '你不可以删除你的自我介绍的首个帖子！',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'				=> '你不可以删除你的自我介绍的首个帖子！但你可以删除整个自我介绍主题。',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'				=> '请在主题P %s 中介绍你自己',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'					=> '<strong>要发表帖子， <u>你必须</u> 先自我介绍</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'					=> '作为一个新用户，你必须先对其他用户作自我介绍，到板块 “<a href="%forum_url%">%forum_name%</a>” 发表自我介绍<br/>
																	在自我介绍板块只有新主题才被允许。',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES'				=> '<br/>
																	当创建自我介绍主题，请先看一下显示在论坛版块顶部的规则。',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'						=> '<strong><u>版规也重复显示在：“</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM'					=> '<a href="%forum_url%">点击前往 “%forum_name%” 板块</a>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM'					=> '<a href="%forum_post%">点击此链接发布你的自我介绍</a>',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'					=> '<br/>在等待审核期间，你可以编辑它，版主也可以回复你。
																	<br/>这可以让你的自我介绍更加的合乎版规的要求。',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'							=> '用户的自我介绍',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'					=> '此用户没有自我介绍',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'						=> '查看用户的自我介绍',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'			=> '此用户的自我介绍正等待审核',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'							=> '到用户的自我介绍',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'							=> '用户的自我介绍等待审核',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'							=> '此用户没有自我介绍',
));
