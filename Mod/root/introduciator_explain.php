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

if ($config['introduciator_allow'])
{	// Title messagte
	// Load MOD configuration
	$params = introduciator_getparams(false);

	$message = $user->lang('INTRODUCIATOR_MOD_MUST_INTRODUCE_INTO_FORUM', $params['forum_name']);
	page_header($message);

	$template->set_filenames(array(
		'body' => 'introduciator_explain.html',
	));
	
	$template->assign_vars(array(
		'S_MOD_ACTIVATED'					=> true,
		'INTRODUCIATOR_MOD_EXPLAIN_TITLE'	=> $params['explanation_message_title'],
		'INTRODUCIATOR_MOD_EXPLAIN_TEXT'	=> $params['explanation_message_text'],
		'S_RULES_ACTIVATED'					=> $params['is_explanation_display_rules'] && strlen($params['explanation_message_rules_text']) > 0,
		'S_RULES_TITLE_ACTIVATED'			=> (strlen($params['explanation_message_rules_title']) > 0),
		'INTRODUCIATOR_MOD_RULES_TITLE'		=> $params['explanation_message_rules_title'],
		'INTRODUCIATOR_MOD_RULES_TEXT'		=> $params['explanation_message_rules_text'],
		'INTRODUCIATOR_MOD_LINK_GOTO_FORUM'	=> $params['explanation_message_goto_forum'],
		'INTRODUCIATOR_MOD_LINK_POST_FORUM'	=> $params['explanation_message_post_forum'],
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