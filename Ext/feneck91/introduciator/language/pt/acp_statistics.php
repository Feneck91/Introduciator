<?php

/**
 * @package phpBB Extension - Introduciator Extension for phpBB.
 * info_acp_introduciator.php [English]
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'INTRODUCIATOR_ST_TITLE'         => 'Estatísticas e verificações sobre a apresentação de utilizadores',
	'INTRODUCIATOR_ST_TITLE_EXPLAIN' => 'Usado para mostrar informações da base de dados:
														<ul>
														<li>As estatísticas sobre apresentações.</li>
														<li>A verificação de coerência da base de dados sobre a apresentação do utilizador (verificar se os utilizadores publicaram mais de uma apresentação).</li>
														</ul>',
	'INTRODUCIATOR_ST_MAIN_STATISTICS_TITLE'      => 'Estatísticas gerais',
	'INTRODUCIATOR_ST_NB_INTRODUCTION_TITLE'      => 'Número de apresentações no fórum:',
	'INTRODUCIATOR_ST_ARRAY_TITLE'                => 'Esta matriz indica todas as apresentações que foram publicadas mais do que uma vez',
	'INTRODUCIATOR_ST_ARRAY_NO_MULTIPLE_DETECTED' => 'Nenhuma apresentação múltipla detetada',
	'INTRODUCIATOR_ST_ARRAY_HEADER_USER'          => 'Utilizador',
	'INTRODUCIATOR_ST_ARRAY_HEADER_DATE'          => 'Data',
	'INTRODUCIATOR_ST_ARRAY_HEADER_INTRODUCE'     => 'Apresentações',
	'INTRODUCIATOR_ST_CHECK'                      => 'Verificar',
]);
