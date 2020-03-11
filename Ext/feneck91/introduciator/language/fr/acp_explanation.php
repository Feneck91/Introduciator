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
* mode: explication
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_EP_' pour 'INTRODUCIATOR_EXPLANATION_PAGES_'
*/
$lang = array_merge($lang, array(
	// Titres
	'INTRODUCIATOR_EP_TITLE'										=> 'Configuration de la page d’explications de la Présentation forcée',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'								=> 'Permet de configurer la page d’explications de l’extension.',

	// Paramétrage : configuration de la page
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'						=> 'Configuration de la page d’explications',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'									=> 'Afficher la page d’explications :',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'							=> 'Est utilisé pour afficher la page d’explications si l’utilisateur tente de poster dans un autre forum que celui des présentations.',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'						=> 'Activer l’affichage des règles du forum de présentation :',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'				=> 'Permet d’afficher les règles du forum de présentation dans la page d’explication.',

	// Paramétrage : configuration du texte de la page
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'					=> 'Configuration des textes de la page d’explications',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN'			=> 'Pour tous les champs textes suivants, vous pouvez utiliser :<br/>
																		<ul>
																		<li><b>%forum_name%</b> : nom du forum de présentation</li>
																		<li><b>%forum_url%</b> : url vers le forum de présentation</li>
																		<li><b>%forum_post%</b> : url pour l’écriture d’un nouveau post dans le forum de présentation</li>
																		</ul>
																		Vous pouvez utiliser les BBcodes pour créer les messages.<br/>
																		<br/>
																		<u>Exemples :</u>
																		<ul>
																		<li>Créer un lien vers le forum de présentation : <i>[url=<b>%forum_url%</b>]Cliquez ici pour aller au forum ’<b>%forum_name%</b>’[/url]</i>
																		<li>Créer un lien de création du sujet dans le forum de présentation : <i>[url=<b>%forum_post%</b>]Cliquez ici pour créer un nouveau sujet dans le forum ’<b>%forum_name%</b>’[/url]</i>
																		</ul>
																		<br/>',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'								=> 'Titre de la page d’explications :',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'						=> 'Défaut = <b>%explanation_title%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'									=> 'Texte de la page d’explications :',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'							=> 'Défaut = <b>%explanation_text%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
	'INTRODUCIATOR_EP_RULES_TITLE'									=> 'Titre de la présentation des règles :',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'							=> 'Défaut = <b>%rules_title%</b><br/>Vous pouvez changer le texte pour mettre celui de votre choix.',
	'INTRODUCIATOR_EP_RULES_TEXT'									=> 'Texte des règles du forum de présentation :',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'							=> 'Défaut = <b>%rules_text%</b><br/>Par défaut %rules_text% est remplacé par le texte des règles du forum de présentation.<br/>Vous pouvez changer le texte pour mettre celui de votre choix.',

	// Logs
	'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED'						=> '<strong>Présentation forcée : configuration des explications mise à jour.</strong>',

	// Confirm box
	'INTRODUCIATOR_EP_UPDATED'										=> 'La configuration de la page d’explication a été mise à jour',
));
