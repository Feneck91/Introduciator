<?php

/**
 * @package phpBB Extension - Introduciator Extension for phpBB.
 * introduciator.php [English]
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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

/*
* General messages
*/
$lang = array_merge($lang, [
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'           => 'A sua mensagem de apresentação aguarda aprovação, por favor aguarde.',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT' => 'Durante a aprovação da sua mensagem de apresentação, apenas a edição é permitida.',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'                => 'Não tem permissão para se apresentar mais do que uma vez!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'          => 'Não tem permissão para excluir a primeira mensagem da sua apresentação!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'             => 'Não tem permissão para excluir a primeira mensagem desta apresentação! Pode excluir esta apresentação eliminando o tópico.',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'               => 'Por favor apresente-se no tópico: %s',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'                   => '<strong>Para poder publicar, <u>deve</u> apresentar-se</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'                    => 'Como para cada novo usuário, deve apresentar-se aos outros membros no fórum "<a href="%forum_url%">%forum_name%</a>"<br/>
																	Apenas é permitido um novo tópico no fórum de apresentações.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES' => '<br/>
																	Ao criar o tópico de apresentação, por favor observe as seguintes regras que também são apresentadas no topo do fórum de apresentações.',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'     => '<strong><u>As regras são repetidas aqui:</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM' => '<a href="%forum_url%">Vá para o fórum "%forum_name%" agora clicando neste link</a>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM' => '<a href="%forum_post%">Apresente-se agora clicando neste link</a>',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'    => '<br/>Durante a aprovação da apresentação, a mesma permanece editável e os moderadores podem responder-lhe.
																	<br/>Isto irá permitir-lhe colocá-la em conformidade com os requisitos do fórum, se necessário.',
	'INTRODUCIATOR_MEMBER_INTRODUCTION'                 => 'Apresentação do membro',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'          => 'Nenhuma apresentação disponível para este membro',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'             => 'Ver a apresentação do membro',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION' => 'A apresentação deste membro aguarda aprovação',
	'INTRODUCIATOR_VIEW_MEMBER_GOTO'                    => 'Ir para a apresentação do membro',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'                 => 'A apresentação do membro aguarda aprovação',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'                 => 'Nenhuma apresentação disponível para este membro',
]);
