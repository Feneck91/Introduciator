<?php
/**
*
* @package Introduciator MOD
* @author Feneck91 (Stéphane Château) feneck91@free.fr
* @version $Id$
* @copyright (c) 2013 @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Documentation : https://wiki.phpbb.com/Creating_modules
*/

define('IN_PHPBB', true);   // Protect subfoder files to direct access

// Include common php file, in the root of the phpbb forum
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
// Include introduciator functions
include($phpbb_root_path . 'includes/functions_introduciator.' . $phpEx); // For defines

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Start initial var setup
$forum_id	= request_var('f', 0);

// If user not connected, go to login page
if ($user->data['user_id'] == ANONYMOUS)
{
    login_box('', $user->lang['LOGIN']);
}

// Load langage
$user->add_lang('mods/introduciator');

if ($config['introduciator_allow'])
{	// Title messagte
	// Load MOD configuration
	$params = introduciator_getparams();

	$forum_name = '';
	$forum_rules = array();

	// Find Forum name
	$sql = 'SELECT forum_name, forum_rules, forum_rules_uid, forum_rules_bitfield, forum_rules_options
			FROM ' . FORUMS_TABLE . '
			WHERE forum_id = ' . (int) $params['fk_forum_id'];
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);

	if ($row)
	{
		$forum_name = $row['forum_name'];
		$forum_rules = array(
			'rules'				=> $row['forum_rules'],
			'rules_uid'			=> $row['forum_rules_uid'],
			'rules_bitfield'	=> $row['forum_rules_bitfield'],
			'rules_options'		=> $row['forum_rules_options'],
		);
	}
	$db->sql_freeresult($result);

	$message = $user->lang('INTRODUCIATOR_MOD_MUST_INTRODUCE_INTO_FORUM', $forum_name);
	page_header($message);

	$template->set_filenames(array(
		'body' => 'introduciator_explain.html',
	));

	$explanation_title = str_replace('%explanation_title%', $user->lang['INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TITLE'], $params['explanation_message_title']);
	$explanation_text = str_replace('%explanation_text%', $user->lang['INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TEXT'], $params['explanation_message_text']);
	$rules_title = str_replace('%rules_title%', $user->lang['INTRODUCIATOR_MOD_DEFAULT_RULES_TITLE'], $params['explanation_message_rules_title']);
	$rules_text = $params['explanation_message_rules_text'];
	$link_goto_forum = $user->lang['INTRODUCIATOR_MOD_DEFAULT_LINK_GOTO_FORUM'];
	$link_post_forum = $user->lang['INTRODUCIATOR_MOD_DEFAULT_LINK_POST_FORUM'];

	// Replace in each string the predefined fields
	replace_all_by(
		array(
			&$explanation_title,
			&$explanation_text,
			&$rules_title,
			&$rules_text,
			&$link_goto_forum,
			&$link_post_forum
		),
		array(
			'%forum_name%'	=> $forum_name,
			'%forum_url%'	=> "http://www.dummy.com/aghxkfps.php", // Make link work
			'%forum_post%'	=> "http://www.dummy.com/aghxkfps.php", // Make link work
		)
	);

	$explanation_message_rules_text_new_uid = $explanation_message_rules_text_new_bitfield = $explanation_message_rules_text_bbcode_options = '';
	$texts_errors = generate_text_for_storage($rules_text, $explanation_message_rules_text_new_uid, $explanation_message_rules_text_new_bitfield, $explanation_message_rules_text_bbcode_options, true, true, true);
	if (sizeof($texts_errors) == 0)
	{	// Only if no errors
		$forum_rules_display = generate_text_for_display($forum_rules['rules'], $forum_rules['rules_uid'], $forum_rules['rules_bitfield'], $forum_rules['rules_options']);
		$forum_user_rules_display = generate_text_for_display($rules_text, $explanation_message_rules_text_new_uid, $explanation_message_rules_text_new_bitfield, $explanation_message_rules_text_bbcode_options);
		$rules_text = str_replace('%rules_text%', $forum_rules_display, $forum_user_rules_display);
		// Make link work
		replace_all_by(
			array(
				&$rules_text
			),
			array(
				'%forum_name%'						=> $forum_name,
				'http://www.dummy.com/aghxkfps.php'	=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $params['fk_forum_id']),
				'http://www.dummy.com/aghxkfps.php'	=> append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=post&amp;f=' . $params['fk_forum_id']),
			)
		);
	}
	else
	{
		$rules_text = implode('<br>', $errors); // If error, no rules displayed
	}
	// Only display rules if rules field is filled
	$is_rules_filled = $params['is_explanation_display_rules'] && strlen($rules_text) > 0;

	$template->assign_vars(array(
		'S_MOD_ACTIVATED'					=> true,
		'FORUM_NAME'						=> $forum_name,
		'FORUM_HREF'						=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $params['fk_forum_id']),
		'FORUM_HREF_POST'					=> append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=post&amp;f=' . $params['fk_forum_id']),
		'FORUM_RULES'						=> $rules_text,
		'INTRODUCIATOR_MOD_EXPLAIN_TITLE'	=> $explanation_title,
		'INTRODUCIATOR_MOD_EXPLAIN_TEXT'	=> $explanation_text,
		'S_RULES_ACTIVATED'					=> $is_rules_filled,
		'S_RULES_TITLE_ACTIVATED'			=> (strlen($rules_title) > 0),
		'INTRODUCIATOR_MOD_RULES_TITLE'		=> $rules_title,
		'INTRODUCIATOR_MOD_RULES_TEXT'		=> $rules_text,
		'INTRODUCIATOR_MOD_LINK_GOTO_FORUM'	=> $link_goto_forum,
		'INTRODUCIATOR_MOD_LINK_POST_FORUM'	=> $link_post_forum,
	));

	page_footer();
}
else
{
	page_header($user->lang['INTRODUCIATOR_MOD_DISABLED']);
	$template->set_filenames(array(
		'body' => 'introduciator_explain.html',
	));

	page_footer();
}

?>