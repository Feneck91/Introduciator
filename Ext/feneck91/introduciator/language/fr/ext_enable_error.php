<?php
/**
 * ext_enable_error.php [Français]
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
	$lang = [];
}

$lang = array_merge($lang, [
	'INTRODUCIATOR_ENABLE_ERROR_PHPBB_VERSION' => 'Introduciator nécessite phpBB 3.2.8 ou une version plus récente.',
	'INTRODUCIATOR_ENABLE_ERROR_STORE'         => 'Introduciator n\'a pas pu créer <strong>%s</strong> ni y écrire. Ce répertoire est nécessaire pour empêcher les utilisateurs de publier plus d\'une présentation ; veuillez le rendre accessible en écriture au serveur web avant d\'activer l\'extension.',
	'INTRODUCIATOR_STORE_NOT_WRITABLE'         => 'Introduciator ne peut pas écrire dans <strong>%s</strong>. La protection contre les présentations en double est actuellement désactivée. Rendez ce répertoire accessible en écriture au serveur web pour la réactiver.',
]);
