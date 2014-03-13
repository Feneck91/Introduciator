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
	'INTRODUCIATOR_GENERAL'					=> 'Général',
	'INTRODUCIATOR_CONFIGURATION'			=> 'Configuration',
));

/**
* Clef de langue communes
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_NAME'							=> 'Nom de l\'agenda',
));

/**
* mode: general
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_GP_' pour 'INTRODUCIATOR_GENERAL_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_GP_TITLE'						=> 'Informations générales',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'				=> 'Donne la version courante de ce MOD',

	'INTRODUCIATOR_GP_VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Votre installation du MOD Diary n’est pas à jour.',
	'INTRODUCIATOR_GP_STATS'						=> 'Statistiques de l\'agenda',
	'INTRODUCIATOR_GP_INSTALL_DATE'					=> 'Date d’installation du MOD <strong>Diary</strong> :',
	'INTRODUCIATOR_GP_VERSION'						=> 'Version du MOD <strong>Diary</strong> :',
));

/**
* mode: configuration
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_TITLE'				=> 'Configuration des agendas',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'		=> 'Permet de créer / supprimer / éditer les agendas',
	'INTRODUCIATOR_CP_CREATE_INTRODUCIATOR'			=> 'Création d\'un agenda',
));

/**
* mode: configuration : Edit
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_CP_ED_' pour 'INTRODUCIATOR_CONFIGURATION_PAGES_EDIT_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_CP_ED_NAME'						=> 'Nom de l\'agenda',
	'INTRODUCIATOR_CP_ED_NAME_EXPLAIN'				=> 'Permet de nommer l\'agenda. Ce nom est visible dans la liste des agendas dans l\'ACP.',
	'INTRODUCIATOR_CP_ED_TAG'						=> 'Tag',
	'INTRODUCIATOR_CP_ED_TAG_EXPLAIN'				=> 'Tag sur 3 caractères. Tous les événements créés par cet agenda sont créés avec ce tag.<br/>Ceci permet de partager des événements entre plusieurs agendas',
	'INTRODUCIATOR_CP_ED_FILTER_TAG'				=> 'Filtre des tags',
	'INTRODUCIATOR_CP_ED_FILTER_TAG_EXPLAIN'		=> 'Filtre de Tags sur 3 caractères, un tag par ligne.<br/>Pour que l\'événements apparaisse il faut que le filtre contienne le même tag que l\'agenda qui l\'a créé.<br/>Ceci permet de partager des événements entre plusieurs agendas',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICES'				=> 'Choix des forums où sera affiché cet agenda',
	'INTRODUCIATOR_CP_ED_FORUM_CHOICES_EXPLAIN'		=> 'Permet de choisir un ou plusieur forums où cet agenda sera affiché',

	// Elément racine de la liste des forums
	'INTRODUCIATOR_CP_ED_MAIN_PAGE'					=> 'Page d\'accueil',
	// Tooltip associé
	'INTRODUCIATOR_CP_ED_MAIN_PAGE_TOOLTIP'			=> 'Page pricipale du forum',
));

/**
* mode: events_types
* Info: Les clefs de langages sont préfixés avec 'INTRODUCIATOR_ETP_' pour 'INTRODUCIATOR_EVENTS_TYPES_PAGES_'
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_ETP_TITLE'				=> 'Page event type',
	'INTRODUCIATOR_ETP_TITLE_EXPLAIN'		=> 'Explication event type',
));

/**
* Autre
*/
$lang = array_merge($lang, array(
	'ERROR_NO_INTRODUCIATOR_ID'					=> 'Élément de l\'agenda non trouvé !',
	'ERROR_INTRODUCIATOR_NAME_EMPTY'			=> 'Le nom de l\'agenda ne doit pas être vide !',
	'ERROR_INTRODUCIATOR_ITEM_TAG_INVALID'		=> 'Le tag de l\'agenda doit faire 3 caractères !',
));

/**
* logs
*/
$lang = array_merge($lang, array(
	//logs
	'LOG_INTRODUCIATOR_CONFIGURATION_ITEM'	=> 'Diary',
	'LOG_INTRODUCIATOR_UPDATED'				=> '<strong>Diary : Configuration mise à jour.</strong>',
	'LOG_INTRODUCIATOR_ITEM_ADDED'			=> '<strong>Diary : %1$s ajouté</strong><br />» %2$s',
	'LOG_INTRODUCIATOR_ITEM_UPDATED'		=> '<strong>Diary : %1$s mis à jour</strong><br />» %2$s',
	'LOG_INTRODUCIATOR_ITEM_REMOVED'		=> '<strong>Diary : %1$s supprimé(e)</strong>',
	'LOG_INTRODUCIATOR_ITEM_MOVE_DOWN'		=> '<strong>Diary : Déplacement de la %1$s. </strong> %2$s <strong>après</strong> %3$s',
	'LOG_INTRODUCIATOR_ITEM_MOVE_UP'		=> '<strong>Diary : Déplacement de la %1$s. </strong> %2$s <strong>avant</strong> %3$s',
));
?>