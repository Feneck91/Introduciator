<?php
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// If user not connected, go to login page
if ($user->data['user_id'] == ANONYMOUS)
{
    login_box('', $user->lang['LOGIN']);
} 

page_header('Veuillez vous pr&eacute;senter dans le Forum : Pr&eacute;sentation des membres');

$forum_pres    = 4;

$template->set_filenames(array(
    'body' => 'mustintroduction.html',
));

page_footer();
?>