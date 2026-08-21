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
* Mode: explanation
* Info: language keys are prefixed with 'INTRODUCIATOR_EP_' for 'INTRODUCIATOR_EXPLANATION_PAGES_'
*/
$lang = array_merge($lang, [
	'INTRODUCIATOR_EP_TITLE'                               => 'Configurações da página de explicações do Introduciator',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'                       => 'Permite configurar as definições da página de explicações do Introduciator.',
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'              => 'Configuração da página de explicações',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'                        => 'Mostrar página de explicação:',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'                => 'Esta opção é usada para mostrar uma página de explicação se o utilizador tentar publicar noutro fórum que não o fórum de apresentações.',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'               => 'Mostrar regras do fórum de apresentações:',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'       => 'Usado para mostrar as regras do fórum de apresentações na página de explicação.',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'         => 'Configuração do texto da página de explicações',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN' => 'Para todos os campos seguintes, podes usar:<br/>
																		<ul>
																		<li><b>%forum_name%</b>: nome do fórum de apresentações</li>
																		<li><b>%forum_url%</b>: url para o fórum de apresentações</li>
																		<li><b>%forum_post%</b>: url para escrever uma nova mensagem no fórum de apresentações</li>
																		</ul>
																		Podes usar BBcodes para fazer mensagens.<br/>
																		<br/>
																		<u>Exemplos:</u>
																		<ul>
																		<li>Criar link para o fórum de apresentações: <i>[url=<b>%forum_url%</b>]Clica aqui para ir para o fórum "<b>%forum_name%</b>"[/url]</i>
																		<li>Criar link para criar tópico no fórum de apresentações: <i>[url=<b>%forum_post%</b>]Clica aqui para criar tópico no fórum "<b>%forum_name%</b>"[/url]</i>
																		</ul>
																		<br/>',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'           => 'Título da página de explicação:',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'   => 'Padrão = <b>%explanation_title%</b><br/>Podes alterar este texto para o teu próprio.',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'            => 'Texto da página de explicação:',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'    => 'Padrão = <b>%explanation_text%</b><br/>Podes alterar este texto para o teu próprio.',
	'INTRODUCIATOR_EP_RULES_TITLE'             => 'Título das regras de explicação:',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'     => 'Padrão = <b>%rules_title%</b><br/>Podes alterar este texto para o teu próprio.',
	'INTRODUCIATOR_EP_RULES_TEXT'              => 'Texto das regras do fórum de apresentações:',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'      => 'Padrão = <b>%rules_text%</b><br/>Por padrão, %rules_text% é substituído pelas regras do fórum de apresentações.<br/>Podes alterar este texto para o teu próprio.',
	'INTRODUCIATOR_EP_TOPIC_TITLE_TEMPLATE'         => 'Título do tópico de apresentação:',
	'INTRODUCIATOR_EP_TOPIC_TITLE_TEMPLATE_EXPLAIN' => 'Preenche antecipadamente o campo Assunto quando um membro inicia o seu tópico de apresentação; ele pode continuar a alterá-lo antes de publicar. Deixa vazio para não preencher nada.<br/>Podes usar <b>%username%</b>.<br/>Apenas texto simples, sem BBCode (os títulos de tópicos não suportam).',
	'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED' => '<strong>Introduciator: definições de explicações atualizadas.</strong>',
	'INTRODUCIATOR_EP_UPDATED'                 => 'As definições da página de explicações foram atualizadas',
]);
