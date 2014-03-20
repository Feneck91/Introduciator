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
// but here, no need to edit and merge this source code with phpBB one.
define('INTRODUCIATOR_CONFIG_TABLE',	$table_prefix . 'introduciator_config');

/**
 * Execute rsql request and return the int value.
 *
 * @param string $sql SQL request to execute
 * @param string $variable_name variable name to read.
 *
 * @return The int value read from $variable_name name.
 */
function execute_sql_value($sql,$variable_name)
{
	global $db; // Database
	$result = $db->sql_query($sql);
	$value = (int) $db->sql_fetchfield($variable_name);
	$db->sql_freeresult($result);
	return $value;
}

?>