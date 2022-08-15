<?php

/**
 * info_acp_introduciator.php [English]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) 2022 Leinad4Mind
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
	$lang = [];
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
 * mode: statistics
 * Info: language keys are prefixed with 'INTRODUCIATOR_ST_' for 'INTRODUCIATOR_STATISTICS_PAGES_'
 */
$lang = array_merge($lang, [
	// Titles
	'INTRODUCIATOR_ST_TITLE'						=> 'Statistics and checks about user’s introduction',
	'INTRODUCIATOR_ST_TITLE_EXPLAIN'				=> 'Used to display database informations:
														<ul>
														<li>The statistics about introductions.</li>
														<li>The database coherence check about user’s introduction (check if users have post more than one introduction).</li>
														</ul>',

	// Number of introduce's texts
	'INTRODUCIATOR_ST_MAIN_STATISTICS_TITLE'		=> 'Generales statistics',
	'INTRODUCIATOR_ST_NB_INTRODUCTION_TITLE'		=> 'Number of introduction into the forum:',

	// Array's texts
	'INTRODUCIATOR_ST_ARRAY_TITLE'					=> 'This array indicate all the introduction that have been posted more than once',
	'INTRODUCIATOR_ST_ARRAY_NO_MULTIPLE_DETECTED'	=> 'No multiple introduction detected',
	'INTRODUCIATOR_ST_ARRAY_HEADER_USER'			=> 'User',
	'INTRODUCIATOR_ST_ARRAY_HEADER_DATE'			=> 'Date',
	'INTRODUCIATOR_ST_ARRAY_HEADER_INTRODUCE'		=> 'Introductions',

	// Buttons
	'INTRODUCIATOR_ST_CHECK'						=> 'Check',
]);
