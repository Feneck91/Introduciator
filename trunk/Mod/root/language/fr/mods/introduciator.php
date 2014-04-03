<?php
/**
*
* introduciator.php [Français]
*
* @package Introduciator MOD
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

// Note pour les développeurs
//
// Tous les fichiers de langue doivent utiliser l'encodage UTF-8 sans BOM.
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

/*
* UMIL : These string are used when introduciator MOD is installed
*/
$lang = array_merge($lang, array(
	'INSTALL_INTRODUCIATOR_MOD'					=> 'Installer le Mod Présentation forcée',

	'INSTALL_INTRODUCIATOR_MOD_CONFIRM'			=> 'Êtes-vous prêt à installer le Mod Présentation forcée ?',
	'INSTALL_INTRODUCIATOR_MOD_WELCOME'			=> 'Changements majeurs depuis la version %s',

	'INTRODUCIATOR_MOD'							=> 'Mod Présentation forcée',
	'INTRODUCIATOR_MOD_EXPLAIN'					=> 'UMIL effectuera automatiquement, dans la base de données, tous les changements nécessaires pour le MOD Présentation forcée.',

	'UNINSTALL_INTRODUCIATOR_MOD'				=> 'Désinstaller le Mod Présentation forcée',
	'UNINSTALL_INTRODUCIATOR_MOD_CONFIRM'		=> 'Êtes-vous prêt à désinstaller le Mod Présentation forcée ? Tous les réglages et données sauvegardées par ce MOD seront supprimés !',

	'UPDATE_INTRODUCIATOR_MOD'					=> 'Mettre à jour le Mod Présentation forcée',
	'UPDATE_INTRODUCIATOR_MOD_CONFIRM'			=> 'Êtes-vous prêt à mettre à jour le Mod Présentation forcée ?',

	'UNUSED_LANG_FILES_TRUE'					=> 'Suppression des fichiers non utilisés.',
	'UNUSED_LANG_FILES_FALSE'					=> 'La suppression des fichiers non utilisés n’est pas nécessaire.',
));

/*
* Autre : Messages
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_MOD_INTRODUCE_WAITING_APPROBATION'	=> 'Votre message de présentation est en cours d’approbation, veuillez patienter.',
	'INTRODUCIATOR_MOD_INTRODUCE_MORE_THAN_ONCE'		=> 'Vous n’êtes pas autorisés à vous présenter plus d’une fois !',
	'INTRODUCIATOR_MOD_DELETE_INTRODUCE_MY_FIRST_POST'	=> 'Vous n’êtes pas autorisés à supprimer le premier message de votre présentation !',
	'INTRODUCIATOR_MOD_DELETE_INTRODUCE_FIRST_POST'		=> 'Vous n’êtes pas autorisés à supprimer le premier message d’une présentation, supprimez toute la présentation en détruisant le sujet !',
	'INTRODUCIATOR_MOD_MUST_INTRODUCE_INTO_FORUM'		=> 'Veuillez vous présenter dans le Forum : %s',
	'INTRODUCIATOR_MOD_DISABLED'						=> 'Le MOD Présentation forcée est désactivé. Veuillez l’activer pour l’utiliser !',
	'INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TITLE'			=> '<b>Pour pouvoir poster vous devez <u>obligatoirement</u> vous présenter</b>',
	'INTRODUCIATOR_MOD_DEFAULT_MESSAGE_TEXT'			=> 'Pour chaque nouvel utilisateur, il faut commencer par aller se présenter aux autres membres dans le Forum “<a href="%forum_url%">%forum_name%</a>”<br/>'
														.  'Seul la création d’un nouveau message dans le forum de présentation est autorisé<br/>'
														.  'Pour la création du message de présentation, veuillez suivre les règles qui sont affichées en haut du forum de présentation',
	'INTRODUCIATOR_MOD_DEFAULT_RULES_TITLE'				=> '<b><u>Les règles sont rappelées ici :</u></b>',
	'INTRODUCIATOR_MOD_DEFAULT_LINK_GOTO_FORUM'			=> '<a href="%forum_url%">Aller dans le forum “%forum_name%” maintenant en cliquant sur ce lien</a>',
	'INTRODUCIATOR_MOD_DEFAULT_LINK_POST_FORUM'			=> '<a href="%forum_post%">Commencer votre présentation maintenant en cliquant sur ce lien</a>',

	'INTRODUCIATOR_TOPIC_TITLE'							=> 'Présentation du membre',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'			=> 'Pas de présentation disponible pour ce membre',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'				=> 'Voir la présentation de ce membre',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'	=> 'Présentation en cours d’approbation',
));

?>