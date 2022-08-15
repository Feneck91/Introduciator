<?php

/**
 * info_acp_introduciator.php [Français]
 *
 * @package phpBB Extension - Introduciator Extension (Présentation forcée)
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
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
 * mode : configuration
 * Info : Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titres
	'INTRODUCIATOR_CP_TITLE'										=> 'Configuration de la Présentation forcée',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'								=> 'Permet de configurer le fonctionnement de l’extension.',

	// Settings: général
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'							=> 'Forcer l’utilisateur à se présenter :',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN'					=> 'Quand cet option est activée, l’extension force l’utilisateur à poster sa propre présentation avant d’être autorisé à poster dans les autres sujets.
																			<br/>Lorsque cette fonctionalité n’est pas activée, toutes les autres options restent actives.',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST'							=> 'Autorise l’extension à vérifier la suppression du premier message d’un sujet dans le forum de présentation :',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST_EXPLAIN'					=> 'Lorsque cette option est activée, l’extension empèche la suppression du premier message qui a créé le sujet dans le forum de présentation.
																			<br/>Même les modérateurs et les administrateurs n’ont pas cette permission pour être certain que le premier message du sujet est la présentation du membre. Il reste toutefois possible de supprimer le sujet si les permissions le permettent.
																			<br/>Vous pouvez désactiver cette option mais dans ce cas un membre peut avoir plusieurs présentations. Il est recommandé d’activer cette option.',
	'INTRODUCIATOR_CP_FORUM_CHOICE'									=> 'Choix du forum où l’utilisateur doit se présenter :',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'							=> 'Est utilisé pour connaître quel forum doit être testé pour savoir si un utilisateur s’est déjà présenté ou pas.',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'						=> 'Options d’approbation de la présentation :',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN'				=> 'Est utilisé pour forcer l’approbation de la présentation par un modérateur :<br/>
																			<ul>
																			<li><b>Pas d’approbation</b> : ne force pas l’approbation de la présentation, il laisse le traitement par défaut.</li>
																			<li><b>Approbation simple</b> : force l’approbation de la présentation. L’utilisateur ne voit pas sa présentation jusqu’à ce qu’elle soit validée par un modérateur (traitement normal de tous les messages nécessitants une approbation).</li>
																			<li><b>Approbation avec édition</b> : force l’approbation de la présentation. L’utilisateur voit sa présentation immédiatement et peut la modifier. Il ne peut pas poster ailleurs tant qu’elle n’est pas validée par un modérateur. Ceci permet aux modérateurs et à l’utilisateur d’échanger afin que ce dernier puisse mettre son message en conformité avant validation par le modérateur (traitement différent des messages nécessitant une approbation). Seule l’édition est autorisée. Répondre et citer sont interdit.</li>
																			</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'						=> 'Pas d’approbation',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'						=> 'Approbation simple',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'				=> 'Approbation avec édition',

	// Paramétrage : groupes et utilisateurs
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'		=> 'Configuration des groupes et des utilisateurs',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'								=> 'Utiliser les permissions de phbBB :',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'						=> 'Vous pouvez utiliser les permissions de phpBB pour indiquer si un utilisateur doit se présenter ou utiliser la configuration de l’extension (plus simple mais moins performant).',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'						=> 'Utiliser les permissions du forum',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'					=> 'Utiliser la configuration de l’extension',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'						=> 'Groupes inclus ou groupes exclus :',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'				=> 'Lorsque les groupes inclus sont sélectionnés, seuls les utilisateurs des groupes sélectionnés doivent se présenter.<br/>Lorsque les groupes exclus sont sélectionnés, seuls les utilisateurs ne faisant pas parti des groupes sélectionnés doivent se présenter.',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'						=> 'Groupes inclus',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'						=> 'Groupes exclus',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'								=> 'Sélection des groupes :',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'						=> 'Sélectionne les groupes qui doivent être inclus ou exclus.',
	'INTRODUCIATOR_CP_IGNORED_USERS'								=> 'Utilisateurs ignorés :',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'						=> 'Liste des utilisateurs qui ne sont pas obligés de se présenter.<br/>Entrez un utilisateur par ligne.<br/>Utilisé pour les comptes d’administrations ou de tests par exemple.',

	// Messages
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'					=> 'Aucun forum sélectionné',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'					=> 'Merci de sélectionner un forum !',

	// Logs
	'INTRODUCIATOR_CP_LOG_UPDATED'									=> '<strong>Présentation forcée : paramètres de configuration mis à jour.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'										=> 'La configuration a été mise à jour',
));
