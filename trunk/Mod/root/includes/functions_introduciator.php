<?php
/**
*
* @package Diary MOD
* @author Feneck91 (Stéphane Château) feneck91@free.fr
* @version $Id$
* @copyright (c) 2013 @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Documentation : https://wiki.phpbb.com/Creating_modules
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

global $table_prefix;

// Define own constants, could be copy into includes\constants.php
// but here, no need to edit and	 merge this source code with phpBB one.
define('INTRODUCIATOR_CONFIG_TABLE',	$table_prefix . 'introduciator_config');
define('INTRODUCIATOR_GROUPS_TABLE',	$table_prefix . 'introduciator_groups');

/**
 * Verify if .
 *
 * @param $poster_id The poster id
 * @param $mode posting mode, could be 'reply' or 'quote' or 'post'.
 *
 * @return None.
 */
function introduciator_verify($user,$mode)
{
	$params = introduciator_getparams();

	if ($params['is_enabled'])
	{
		$user_id = $user->data['user_id'];
		

	}
}

/**
 * Get the introduciator parameters.
 *
 * @return The introduciator parameters.
 */
function introduciator_getparams()
{
	global $db; // Database

	$sql = 'SELECT *
			FROM  ' . INTRODUCIATOR_CONFIG_TABLE;
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	return $row;
}

?>