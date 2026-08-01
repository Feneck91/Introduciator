<?php
/**
 * info_acp_introduciator.php [Portuguese-Brazil]
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
 * Mode: explanation
 * Info: language keys are prefixed with 'INTRODUCIATOR_EP_' for 'INTRODUCIATOR_EXPLANATION_PAGES_'
 */
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_EP_TITLE'										=> 'Configuração da Página de Explicação',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'								=> 'Permite configurar a página de explicação das apresentações.',

	// Settings: page configuration
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'						=> 'Configuração da Explicação',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'									=> 'Exibir página de explicação:',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'							=> 'Esta opção é usada para exibir a página de explicação quando um usuário tenta criar uma mensagem ou um tópico num fórum que não o das apresentações.',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'						=> 'Exibir regras do fórum na página de explicação:',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'				=> 'Serve para exibir as regras do fórum usado para as apresentações na página de explicações.',

	// Settings: page text configuration
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'					=> 'Configuração do texto na página de explicação',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN'			=> 'Para todos os campos que se seguem, podes usar:<br />
																		<ul>
																		<li><b>%forum_name%</b>: nome do fórum para apresentações</li>
																		<li><b>%forum_url%</b>: url do fórum para apresentações</li>
																		<li><b>%forum_post%</b>: url direto para criação de tópico no fórum para apresentações</li>
																		</ul>
																		É permitido o uso de BBcodes.<br />
																		<br />
																		<u>Exemplos:</u>
																		<ul>
																		<li>Criar um endereço para o fórum das apresentações: <i>[url=<b>%forum_url%</b>]Ir para ’<b>%forum_name%</b>’[/url]</i>
																		<li>Criar um endereço para criar o tópico no fórum das apresentações: <i>[url=<b>%forum_post%</b>]Criar apresentação em ’<b>%forum_name%</b>’[/url]</i>
																		</ul>
																		<br />',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'								=> 'Título da página de explicação:',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'						=> 'Predefinido = <b>%explanation_title%</b><br />Podes colocar o texto que desejares.',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'									=> 'Texto da explicação:',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'							=> 'Predefinido = <b>%explanation_text%</b><br />Podes colocar o texto que desejares.',
	'INTRODUCIATOR_EP_RULES_TITLE'									=> 'Título das regras da explicação:',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'							=> 'Predefinido = <b>%rules_title%</b><br />Podes colocar o texto que desejares.',
	'INTRODUCIATOR_EP_RULES_TEXT'									=> 'Texto das regras do fórum das apresentações:',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'							=> 'Predefinido = <b>%rules_text%</b><br />Por padrão, a %rules_text% é substituída pelas regras do fórum de apresentação.<br />Podes colocar o texto que desejares.',

	// Confirm box
	'INTRODUCIATOR_EP_UPDATED'										=> 'A configuração da página de explicação foi atualizada com sucesso',
));
