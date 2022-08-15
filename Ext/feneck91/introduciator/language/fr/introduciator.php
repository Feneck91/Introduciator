<?php

/**
 * introduciator.php [Français]
 *
 * @package phpBB Extension - Introduciator Extension (Présentation Forcée)
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
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
* Messages généraux
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'			=> 'Votre message de présentation est en cours d’approbation, veuillez patienter.',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'	=> 'Pendant l’approbation de votre message de présentation, seule l’édition est autorisée.',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'				=> 'Vous n’êtes pas autorisé à vous présenter plus d’une fois !',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'			=> 'Vous n’êtes pas autorisé à supprimer le premier message de votre présentation !',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'				=> 'Vous n’êtes pas autorisé à supprimer le premier message d’une présentation, supprimez toute la présentation en détruisant le sujet !',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'				=> 'Veuillez vous présenter dans le Forum : %s',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'					=> '<strong>Pour pouvoir poster vous devez <u>obligatoirement</u> vous présenter</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'					=> 'Comme pour chaque nouvel utilisateur, vous devez vous présenter aux autres membres dans le forum “<a href="%forum_url%">%forum_name%</a>”<br/>
																	Seule la création d’un nouveau sujet dans le forum de présentation est autorisée.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES'				=> '<br/>
																	Lors de la création de votre présentation, veuillez suivre les règles qui sont affichées en haut du forum de présentation.',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'						=> '<strong><u>Les règles sont rappelées ici :</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM'					=> '<a href="%forum_url%">Aller dans le forum “%forum_name%” maintenant en cliquant sur ce lien</a>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM'					=> '<a href="%forum_post%">Commencer votre présentation maintenant en cliquant sur ce lien</a>',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'					=> '<br/>Pendant l’approbation de votre présentation, celle-ci reste modifiable et les modérateurs peuvent vous répondre.
																	<br/>Ceci pourra vous permettre de la mettre en conformité avec les exigences du forum le cas échéant.',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'							=> 'Présentation du membre ',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'					=> 'Pas de présentation disponible pour ce membre',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'						=> 'Voir la présentation de ce membre',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'			=> 'Présentation en cours d’approbation pour ce membre',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'							=> 'Voir la présentation du membre',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'							=> 'La présentation est en cours d’approbation',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'							=> 'Aucune présentation disponible',
));