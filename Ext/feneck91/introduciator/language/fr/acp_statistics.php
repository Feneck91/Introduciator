<?php

/**
 * info_acp_introduciator.php [Français]
 *
 * @package phpBB Extension - Introduciator Extension (Présentation forcée)
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
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
 * mode: statistics
 * Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_ST_' pour 'INTRODUCIATOR_STATISTICS_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titres
	'INTRODUCIATOR_ST_TITLE'						=> 'Statistiques et vérifications sur les présentations des membres',
	'INTRODUCIATOR_ST_TITLE_EXPLAIN'				=> 'Permet d’afficher les informations de la base de données :
														<ul>
														<li>Les statistiques sur les présentations.</li>
														<li>La vérification de la base de données concernant les présentations (vérification que les utilisateurs n’ont pas postés plus d’une seule présentation).</li>
														</ul>',

	// Number of introduce's texts
	'INTRODUCIATOR_ST_MAIN_STATISTICS_TITLE'		=> 'Statistiques générales',
	'INTRODUCIATOR_ST_NB_INTRODUCTION_TITLE'		=> 'Nombre de présentations dans le forum :',

	// Textes du tableau
	'INTRODUCIATOR_ST_ARRAY_TITLE'					=> 'Ce tableau indique toutes les présentations qui ont été postées plus d’une fois',
	'INTRODUCIATOR_ST_ARRAY_NO_MULTIPLE_DETECTED'	=> 'Aucune présentation multiple n’a été détectée',
	'INTRODUCIATOR_ST_ARRAY_HEADER_USER'			=> 'Utilisateur',
	'INTRODUCIATOR_ST_ARRAY_HEADER_DATE'			=> 'Date',
	'INTRODUCIATOR_ST_ARRAY_HEADER_INTRODUCE'		=> 'Présentations',

	// Boutons
	'INTRODUCIATOR_ST_CHECK'						=> 'Vérifier',
));
