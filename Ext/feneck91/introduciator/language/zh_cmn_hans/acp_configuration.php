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
 * Mode: configuration
 * Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_CP_TITLE'										=> '自我介绍 配置设置',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'								=> '允许地扩展的设置做修改。',

	// Settings: general
	'INTRODUCIATOR_CP_EXTENSION_ACTIVATED'							=> '启用扩展：',
	'INTRODUCIATOR_CP_EXTENSION_ACTIVATED_EXPLAIN'					=> '用于开启或者禁用这个扩展。',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'							=> '强制用户做一个自我介绍：',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN'					=> '当此选项启用时，此扩展会强制用户在发布其它帖子之前先发表一个自我介绍。
																			<br />当没有启用时，所有其它的选项保持激活状态。',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST'							=> '授权扩展在自我介绍板块中检查是否删除主题的第一个帖子：',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST_EXPLAIN'					=> '激活此选项后，扩展将阻止在自我介绍板块中，任何主题的第一个帖子被删除。
																			<br />甚至版主或者管理员都没有此权限，来确保每个主题的第一个帖子是真正的自我介绍。 但是任然保留了删除主题的权限。
																			<br />你可以不启用此选项，但是这会给与用户发布多个自我介绍的能力。建议启用此选项。',
	'INTRODUCIATOR_CP_FORUM_CHOICE'									=> '用户必须做自我介绍的论坛板块：',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'							=> '此扩展将只用于此板块，以确认用户已经做了自我介绍。',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'						=> '自我介绍的审核选项：',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN'				=> '用于版主对于自我介绍的审核：<br />
																			<ul>
																			<li><b>无需批准</b>： 不强制批准介绍。默认保留。</li>
																			<li><b>简单批准</b>： 必须审核。 未经版主审核批准，用户看不到自我介绍。 （所有需要审核的消息都是用常规处理）</li>
																			<li><b>带有编辑的批准</b>： 必须审核。用户可以即刻查看自我介绍并且可以修改它。 在版主还未审核之前，他不能在其他地方发布。这可以让让版主和用户交换信息，达成一致，然后再由版主进行审核通过（不寻常的消息处理）。只有编辑是允许的，回复和引用都是禁止的。</li>
																			</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'						=> '无需批准',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'						=> '简单批准',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'				=> '带有编辑的批准',

	// Settings: groups and users
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'		=> '用户组和用户的配置',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'								=> '使用 phpBB 权限：',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'						=> '你可以使用 phpBB 权限或者扩展配置（最简单但效率低） 来指示用户是应该自我介绍否。',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'						=> '用户论坛权限',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'					=> '用户扩展配置',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'						=> '包括或者不包括用户组：',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'				=> '当 « 包括用户组 » 被选择时，只有被选中的用户或者用户组需要做自我介绍。<br />当 « 不包括用户组 » 被选择时，只有不被选中的用户组才需要做自我介绍。',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'						=> '包括用户组',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'						=> '不包括用户组',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'								=> '用户组选择：',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'						=> '选择应当被包括或者不包括的用户组。',
	'INTRODUCIATOR_CP_IGNORED_USERS'								=> '忽略的用户：',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'						=> '不被要求做自我介绍的用户。<br />每行输入一个用户名。<br />这个选项用于测试账号或者管理员账号。',

	// Messages
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'					=> '未选择论坛版块，仅在扩展被禁用的时候使用',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'					=> '当启用此扩展，你应当先选择一个论坛版块！',

	// Logs
	'INTRODUCIATOR_CP_LOG_UPDATED'									=> '<strong>自我介绍： 配置设置更新完成。</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'										=> '配置已更新',
));
