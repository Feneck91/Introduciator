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
$user->setup('mods/introduciator');

// Load MOD configuration
$params = introduciator_getparams();

if ($params['is_enabled'])
{	// Title messagte
	$forum_name = '';
	$forum_rules = array();
	
	// Find Forum name
	$sql = 'SELECT forum_name, forum_rules, forum_rules_uid, forum_rules_bitfield,forum_rules_options
			FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $params['fk_forum_id'];
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
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

	$message = sprintf($user->lang['INTRODUCIATOR_MOD_MUST_INTRODUCE_INTO_FORUM'],$forum_name);
	page_header($message);

	$template->set_filenames(array(
		'body' => 'introduciator_explain.html',
	));
	
	$template->assign_vars(array(
		'S_MOD_ACTIVATED'					=> true,
		'FORUM_NAME'						=> $forum_name,
		'FORUM_HREF'						=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $params['fk_forum_id']),
		'FORUM_HREF_POST'					=> append_sid("{$phpbb_root_path}posting.$phpEx", 'mode=post&f=' . $params['fk_forum_id']),
		'FORUM_RULES'						=> generate_text_for_display($forum_rules['rules'], $forum_rules['rules_uid'], $forum_rules['rules_bitfield'], $forum_rules['rules_options']),
		'INTRODUCIATOR_MOD_EXPLAIN_TITLE'	=> 'Afin d\'accéder au contenu complêt du forum vous devez <u>obligatoirement</u> vous présenter',
	));

	page_footer();
}
else
{
	page_header($user->lang['INTRODUCIATOR_MOD_DISABLED']);
	$template->set_filenames(array(
		'body' => 'introduciator_explain.html',
	));

	$template->assign_vars(array(
		'S_MOD_ACTIVATED'					=> false,
	));
		
	page_footer();
}

?>