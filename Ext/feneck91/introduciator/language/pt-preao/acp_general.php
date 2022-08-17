<?php
/**
 * info_acp_introduciator.php [Portuguese-PreAO]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) 2022 Leinad4Mind
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
 * Mode: general
 * Info: language keys are prefixed with 'INTRODUCIATOR_GP_' for 'INTRODUCIATOR_GENERAL_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_GP_TITLE'							=> 'Informação Geral',
	'INTRODUCIATOR_GP_TITLE_EXPLAIN'					=> 'Verificar versão da extensão.',

	// Extension's informations
	'INTRODUCIATOR_GP_INFOS_ARRAY_HEADER_INFORMATIONS'	=> 'Informações',
	'INTRODUCIATOR_GP_INFOS_ARRAY_HEADER_VALUES'		=> 'Valores',
	'INTRODUCIATOR_GP_INFOS'							=> 'Informações do Introduciator',
	'INTRODUCIATOR_GP_INSTALL_DATE'						=> 'Data de instalação:',
	'INTRODUCIATOR_GP_VERSION'							=> 'Versão:',
	'INTRODUCIATOR_GP_DETAILS'							=> 'Detalhes',
	'INTRODUCIATOR_GP_URL_DETAILS'						=> 'https://www.phpbb.com/customise/db/extension/introduciator/',
));
