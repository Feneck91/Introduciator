<?php
/**
*
* info_acp_diary.php [Français]
*
* @package Diary MOD
* @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
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
* mode: main : Le nom du MOD
*/
$lang = array_merge($lang, array(
	'ACP_INTRODUCIATOR_MOD'							=> 'Présentation forcée',
));

/**
* Titres présents dans la partie gauche de l'onglet .MOD de l'ACP sous l'item INTRODUCIATOR
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_GENERAL'							=> 'Général',
	'INTRODUCIATOR_CONFIGURATION'					=> 'Configuration',
));

/**
* mode: general
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_GP_' pour 'INTRODUCIATOR_GENERAL_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_GP_TITLE'						=> 'Informations générales',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'				=> 'Donne la version courante de ce MOD',

	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Votre installation du MOD Introduciator n’est pas à jour.',
	'INTRODUCIATOR_GP_STATS'						=> 'Statistiques du MOD Introduciator',
	'INTRODUCIATOR_GP_INSTALL_DATE'					=> 'Date d’installation du MOD <strong>Introduciator</strong> :',
	'INTRODUCIATOR_GP_VERSION'						=> 'Version du MOD <strong>Introduciator</strong> :',
));

/**
* mode: configuration
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_TITLE'						=> 'Configuration de la Présentation forcée',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'				=> 'Permet de créer / supprimer / éditer les agendas',
	'INTRODUCIATOR_CP_CREATE_INTRODUCIATOR'			=> 'Permet de sélectionner le forum de présentation, les goupes qui n\'ont pas à se présenter, etc.',
));

/**
* mode: configuration : Edit
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_ED_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE'						=> 'Choix du forum où l\'utilisateur doit se présenter',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE_EXPLAIN'				=> 'Est utilisé pour connaître quel forum doit être testé pour savoir si un utilisateur s\'est déjà présenté ou pas',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE'			=> 'Afficher la page d\explication',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE_EXPLAIN'	=> 'Utilisé pour afficher la page d\'explication si l\'utilisateur tente de poster dans un autre forum que celui des présentations',
));

/**
* logs
*/
$lang = array_merge($lang, array(
	//logs
	'LOG_INTRODUCIATOR_UPDATED'				=> '<strong>Introduciator : Configuration mise à jour.</strong>',
));
?>