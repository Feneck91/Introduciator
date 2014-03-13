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

/**
 * Check if diary should be displayed into the forum or not.
 *
 * @param int $id_diary Diary identifier, if 0 it is new forum, in this case
 *                            return always false (not selected by default)
 * @param int $id_forum Forum identifier. If is 0, it is main page.
 */
function is_diary_displayed_into_forum($id_diary,$id_forum)
{
	$displayed = false;
	if ($id_diary != 0)
	{
		global $db; // Database

		// Query return 0 or 1 without counting all the table entries
		$displayed = is_exists_at_least_once(INTRODUCIATOR_DISPLAY_FORUM_TABLE,
											 sprintf('(fk_diary_id = %d) AND (fk_forum_id = %d)',
													 $id_diary,
													 $id_forum));
	}

	return $displayed;
}

/**
 * Check if a conditionnal request will return 0 or more rows.
 *
 * This use an optimized SQL request to know if a conditional request will return
 * 0 or more results (returns 1).
 *
 * @param string $table_name Table name
 * @param string $where Where request condition, NULL if not needed
 *
 * @return true if the request return at least one row, false else.
 */
function is_exists_at_least_once($table_name,$where)
{
	global $db; // Database

	$result = $db->sql_query(format_sql_exists_at_least_once($table_name,'nresults',$where));
	$is_exists = (((int) $db->sql_fetchfield('nresults')) != 0);
	$db->sql_freeresult($result);
	return $is_exists;
}

/**
 * Format a SQL optimized request to know if a conditional request will return
 * 0 or more results (returns 1).
 * Internet reference : http://stackoverflow.com/questions/14566910/identify-if-at-least-one-row-with-given-condition-exisits
 *
 * @param string $table_name Table name
 * @param string $results_name result name into request
 * @param string $where Where request condition, can be NULL if no needed
 *
 * @return The SQL request correctly formatted.
 */
function format_sql_exists_at_least_once($table_name,$results_name,$where)
{
	return sprintf('SELECT COUNT(1) AS %s ' .
				   'FROM %s ' .
				   'WHERE EXISTS' .
				   '(SELECT 1 ' .
					'FROM %s%s)',$results_name,
								 $table_name,
								 $table_name,
								 $where !== NULL
								 // Where is defined, format it
								 ? sprintf(' WHERE (%s)',$where)
								 // Where is undefined, set empty string
								 : '');
	return $sql;
}

?>