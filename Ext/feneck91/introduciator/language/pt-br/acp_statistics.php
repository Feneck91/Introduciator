<?php

/**
 * info_acp_introduciator.php [English]
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
	$lang = [];
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
 * mode: statistics
 * Info: language keys are prefixed with 'INTRODUCIATOR_ST_' for 'INTRODUCIATOR_STATISTICS_PAGES_'
 */
$lang = array_merge($lang, [
	// Titles
	'INTRODUCIATOR_ST_TITLE'						=> 'Estatísticas e verificações sobre as apresentações do usuário',
	'INTRODUCIATOR_ST_TITLE_EXPLAIN'				=> 'Serve para exibir informações da base de dados:
																<ul>
																<li>Estatísticas sobre as apresentações.</li>
																<li>A base de dados verifica de forma coerente sobre as apresentações dos usuários (verifica que existem múltiplas apresentações pelo mesmo usuário).</li>
																</ul>',

	// Number of introduce's texts
	'INTRODUCIATOR_ST_MAIN_STATISTICS_TITLE'		=> 'Estatísticas Globais',
	'INTRODUCIATOR_ST_NB_INTRODUCTION_TITLE'		=> 'Número de apresentações no fórum:',

	// Array's texts
	'INTRODUCIATOR_ST_ARRAY_TITLE'						=> 'Este array indica todas as apresentações que foram colocadas em excesso',
	'INTRODUCIATOR_ST_ARRAY_NO_MULTIPLE_DETECTED'	=> 'Nenhuma apresentação repetida detetada',
	'INTRODUCIATOR_ST_ARRAY_HEADER_USER'				=> 'Usuário',
	'INTRODUCIATOR_ST_ARRAY_HEADER_DATE'				=> 'Data',
	'INTRODUCIATOR_ST_ARRAY_HEADER_INTRODUCE'			=> 'Apresentações',

	// Buttons
	'INTRODUCIATOR_ST_CHECK'						=> 'Verificar',
]);
