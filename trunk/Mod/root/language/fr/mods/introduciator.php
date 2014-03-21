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
	'INSTALL_INTRODUCIATOR_MOD'					=> 'Installer le Mod Introduciator',

	'INSTALL_INTRODUCIATOR_MOD_CONFIRM'			=> 'Êtes-vous prêt à installer le Mod Introduciator ?',
	'INSTALL_INTRODUCIATOR_MOD_WELCOME'			=> 'Changements majeurs depuis la version 0.0.1-dev',

	'INTRODUCIATOR_MOD'							=> 'Mod Introduciator',
	'INTRODUCIATOR_MOD_EXPLAIN'					=> 'UMIL effectuera automatiquement, dans la base de données, tous les changements nécessaires pour le MOD Introduciator.',

	'UNINSTALL_INTRODUCIATOR_MOD'				=> 'Désinstaller le Mod Introduciator',
	'UNINSTALL_INTRODUCIATOR_MOD_CONFIRM'		=> 'Êtes-vous prêt à désinstaller le Mod Introduciator ? Tous les réglages et données sauvegardées par ce MOD seront supprimés !',

	'UPDATE_INTRODUCIATOR_MOD'					=> 'Mettre à jour le Mod Introduciator',
	'UPDATE_INTRODUCIATOR_MOD_CONFIRM'			=> 'Êtes-vous prêt à mettre à jour le Mod Introduciator ?',

	'UNUSED_LANG_FILES_TRUE'					=> 'Suppression des fichiers non utilisés.',
	'UNUSED_LANG_FILES_FALSE'					=> 'La suppression des fichiers non utilisés n’est pas nécessaire.',
));
?>