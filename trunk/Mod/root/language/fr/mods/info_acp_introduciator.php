<?php
/**
*
* info_acp_introduciator.php [Français]
*
* @package Introduciator MOD (Présentation forcée)
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
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'				=> 'Donne la version courante de ce MOD.',

	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Votre installation du MOD Présentation forcée n’est pas à jour.',
	'INTRODUCIATOR_GP_STATS'						=> 'Statistiques du MOD Présentation forcée',
	'INTRODUCIATOR_GP_INSTALL_DATE'					=> 'Date d’installation du MOD <strong>Présentation forcée</strong> :',
	'INTRODUCIATOR_GP_VERSION'						=> 'Version du MOD <strong>Présentation forcée</strong> :',
	'INTRODUCIATOR_GP_UPDATE_VERSION_TITLE'			=> 'Dernière version :',
	'INTRODUCIATOR_GP_UPDATE_URL_TITLE'				=> 'Lien de téléchargement :',
	'INTRODUCIATOR_GP_UPDATE_INFOS_TITLE'			=> 'Information de mise à jour :',
));

/**
* mode: configuration
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_TITLE'						=> 'Configuration de la Présentation forcée',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'				=> 'Permet de configurer le fonctionnement du MOD.',
));

/**
* mode: configuration : Edit
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_ED_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
$lang = array_merge($lang, array(
	// Titres
	'GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'						=> 'Configuration des groupes et des utilisateurs',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS'								=> 'Configuration de la page d’explications',
	'GENERAL_OPTIONS_EXPLANATION_TEXTS_EXPLAIN'						=> 'Pour tous les champs textes suivants, vous pouvez utiliser :<br/>
																		<ul>
																		<li><b>%forum_name%</b> : nom du forum de présentation</li>
																		<li><b>%forum_url%</b> : url vers le forum de présentation</li>
																		<li><b>%forum_post%</b> : url pour l’écriture d’un nouveau post dans le forum de présentation</li>
																		</ul>',
	// Sous-titres
	'INTRODUCIATOR_CP_ED_MOD_ACTIVATED'								=> 'Activer le MOD',
	'INTRODUCIATOR_CP_ED_MOD_ACTIVATED_EXPLAIN'						=> 'Est utilisé pour activer ou désactiver ce MOD.',
	'INTRODUCIATOR_CP_ED_CHECK_DEL_1ST_POST'						=> 'Autorise le MOD à vérifier la suppression du premier message d’un sujet dans le forum de présentation',
	'INTRODUCIATOR_CP_ED_CHECK_DEL_1ST_POST_EXPLAIN'				=> 'Lorsque cette option est activée, le MOD empèche la suppression du premier message qui a créé le sujet dans le forum de présentation.
																		<br/>Même les modérateurs et les administrateurs n’ont pas cette permission pour être certain que le premier message du sujet est la présentation du membre. Il reste toutefois possible de supprimer le sujet si les permissions le permettent.
																		<br/>Vous pouvez désactiver cette option mais dans ce cas un membre peut avoir plusieurs présentations. Il est recommandé d’activer cette option.',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE'								=> 'Choix du forum où l’utilisateur doit se présenter',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICE_EXPLAIN'						=> 'Est utilisé pour connaître quel forum doit être testé pour savoir si un utilisateur s’est déjà présenté ou pas.',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE'					=> 'Afficher la page d’explications',
	'INTRODUCIATOR_CP_ED_DISPLAY_EXPLANATION_PAGE_EXPLAIN'			=> 'Est utilisé pour afficher la page d’explications si l’utilisateur tente de poster dans un autre forum que celui des présentations.',

	'INTRODUCIATOR_CP_ED_USE_PERMISSIONS'							=> 'Utiliser les permissions de phbBB',
	'INTRODUCIATOR_CP_ED_USE_PERMISSIONS_EXPLAIN'					=> 'Vous pouvez utiliser les permissions de phpBB pour indiquer si un utilisateur doit se présenter ou utiliser la configuration de ce MOD (plus simple mais moins performant).<br/><br/>Lorsque l’option « Utiliser les permissions du forums » est sélectionné, la configuration ci-dessous est ignorée.',
	'INTRODUCIATOR_CP_ED_USE_PERMISSION_OPTION'						=> 'Utiliser les permissions du forum',
	'INTRODUCIATOR_CP_ED_NOT_USE_PERMISSION_OPTION'					=> 'Utiliser la configuration du MOD',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS'					=> 'Groupes inclus ou groupes exclus',
	'INTRODUCIATOR_CP_ED_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'			=> 'Lorsque les groupes inclus sont sélectionnés, seuls les utilisateurs des groupes sélectionnés doivent se présenter.<br/>Lorsque les groupes exclus sont sélectionnés, seuls les utilisateurs ne faisant pas parti des groupes sélectionnés doivent se présenter.',
	'INTRODUCIATOR_CP_ED_INCLUDE_GROUPS_OPTION'						=> 'Groupes inclus',
	'INTRODUCIATOR_CP_ED_EXCLUDE_GROUPS_OPTION'						=> 'Groupes exclus',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS'							=> 'Sélection des groupes',
	'INTRODUCIATOR_CP_ED_SELECTED_GROUPS_EXPLAIN'					=> 'Sélectionne les groupes qui doivent être inclus ou exclus.',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS'								=> 'Utilisateurs ignorés',
	'INTRODUCIATOR_CP_ED_IGNORED_USERS_EXPLAIN'						=> 'Liste des utilisateurs qui ne sont pas obligés de se présenter.<br/>Entrer un utilisateur par ligne.<br/>Utilisé pour les comptes d’administrations ou de tests par exemple.',

	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE'					=> 'Titre de la page d’explications',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TITLE_EXPLAIN'			=> 'Défaut = <b>%explanation_title%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT'					=> 'Texte de la page d’explications',
	'INTRODUCIATOR_CP_ED_EXPLANATION_MESSAGE_TEXT_EXPLAIN'			=> 'Défaut = <b>%explanation_text%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED'			=> 'Activer l’affichage des règles du forum de présentation',
	'INTRODUCIATOR_CP_ED_EXPLANATION_DISPLAY_RULES_ENABLED_EXPLAIN'	=> 'Permet d’afficher les règles du forum de présentation dans la page d’explication.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE'					=> 'Titre de la présentation des règles',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TITLE_EXPLAIN'			=> 'Défaut = <b>%rules_title%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT'					=> 'Texte des règles du forum de présentation',
	'INTRODUCIATOR_CP_ED_EXPLANATION_RULES_TEXT_EXPLAIN'			=> 'Défaut = <b>%rules_text%</b><br/>Par défaut %rules_text% est remplacé par le texte des règles du forum de présentation.<br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
));

/**
* Autres
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_NO_FORUM_CHOICE_TOOLTIP'					=> 'Aucun forum sélectionné, à utiliser uniquement lorsque le MOD est désactivé',
	'INTRODUCIATOR_ERROR_MUST_SELECT_FORUM'					=> 'Lorsque ce MOD est activé vous devez choisir un forum !',
	'INTRODUCIATOR_NO_UPDATE_INFO_FOUND'					=> 'Aucune information de mise à jour disponible',
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