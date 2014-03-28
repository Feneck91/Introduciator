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
* mode: main : le nom du MOD
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
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'				=> 'Permet de configurer le fonctionnement du MOD',
	'INTRODUCIATOR_CP_CREATE_INTRODUCIATOR'			=> 'Permet de sélectionner le forum de présentation, les goupes qui n’ont pas à se présenter, etc.',
));

/**
* mode: configuration : Edit
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_ED_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
$lang = array_merge($lang, array(
	// Titres
	'GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'						=> 'Configuration des groupes et des utilisateurs',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS'								=> 'Configuration de la page d’explications',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS_EXPLAIN'						=> 'Pour tous les champs textes suivants, vous pouvez utiliser :<br/>'
																	.  '<ul>'
																	.  '<li><b>%forum_name%</b> : nom du forum de présentation</li>'
																	.  '<li><b>%forum_url%</b> : url vers le forum de présentation</li>'
																	.  '<li><b>%forum_post%</b> : url pour l’écriture d’un nouveau post dans le forum de présentation</li>'
																	.  '</ul>',
	// Sous-titres
	"INTRODUCIATOR_CP_ED_MOD_ACTIVATED"								=> 'Activer le MOD',
	"INTRODUCIATOR_CP_ED_MOD_ACTIVATED_EXPLAIN"						=> 'Utilisé pour activer ou désactiver ce MOD',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE'								=> 'Choix du forum où l’utilisateur doit se présenter',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE_EXPLAIN'						=> 'Est utilisé pour connaître quel forum doit être testé pour savoir si un utilisateur s’est déjà présenté ou pas',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE'					=> 'Afficher la page d’explication',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE_EXPLAIN'			=> 'Utilisé pour afficher la page d’explication si l’utilisateur tente de poster dans un autre forum que celui des présentations',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS'					=> 'Groupes inclus ou groupes exclus',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'			=> 'Lorsque les groupes inclus sont sélectionnés, seuls les utilisateurs des groupes sélectionnés doivent se présenter.<br/>Lorsque les groupes exclus sont sélectionnés, seuls les utilisateurs ne faisant pas parti des groupes sélectionnés doivent se présenter',
	'INTRODUCIATOR_CP_ED_INCLUDE_GROUPS_OPTION'						=> 'Groupes inclus',
	'INTRODUCIATOR_CP_ED_EXCLUDE_GROUPS_OPTION'						=> 'Groupes exclus',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS'							=> 'Sélection des groupes',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS_EXPLAIN'					=> 'Sélectionne les groupes qui doivent être inclus ou exclus',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS'								=> 'Utilisateurs ignorés',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS_EXPLAIN'						=> 'Liste des utilisateurs qui ne sont pas obligés de se présenter.<br/>Entrez un utilisateur par ligne.<br/>Utilisé pour les comptes d’administrations ou de tests par exemple',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE'					=> 'Titre de la page d’explications',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE_EXPLAIN'			=> 'Défaut = <b>%explanation_title%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT'					=> 'Texte de la page d’explications',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT_EXPLAIN'			=> 'Défaut = <b>%explanation_text%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED'			=> 'Activer l’affichage des règles du forum de présentation',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED_EXPLAIN'	=> 'Permet d’afficher les règles du forum de présentation dans la page d’explication',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE'					=> 'Titre de la présentation des règles',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE_EXPLAIN'			=> 'Défaut = <b>%rules_title%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT'					=> 'Texte des règles du forum de présentation',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT_EXPLAIN'			=> 'Défaut = <b>%rules_text%</b><br/>Par défaut %rules_text% est remplacé par le texte des règles du forum de présentation.<br/>Vous pouvez changer le texte pour mettre celui de votre choix',
));

/**
* Autres
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'					=> 'Lorsque ce MOD est activé vous devez choisir un forum !',
));

/**
* logs
*/
$lang = array_merge($lang, array(
	//logs
	'LOG_INTRODUCIATOR_UPDATED'				=> '<strong>Présentation forcée : configuration mise à jour.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'				=> 'La configuration a été mise à jour',
));
?>