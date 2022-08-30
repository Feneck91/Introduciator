<?php

/**
 * introduciator.php [Portuguese-PreAO]
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
 * General messages
 */
$lang = array_merge($lang, array(
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'			=> 'A tua apresentação está em aprovação, por favor, aguarde.',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'	=> 'Enquanto a apresentação se encontrar em aprovação, apenas te é possível editar a mensagem.',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'				=> 'Não te podes apresentar pela segunda vez!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'			=> 'Não tens permissão para remover a primeira mensagem da tua apresentação!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'				=> 'Não tens permissão para remover a primeira mensagem da tua apresentação! Podes remover a apresentação apagando o tópico.',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'				=> 'Por favor, apresenta-te: %s',
	'INTRODUCIATOR_EXT_DISABLED'								=> 'A extensão está desactivada. Tens de a activar para que funcione.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'					=> '<strong>Para poderes usar o fórum, <u>deves</u> apresentar-te</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'					=> 'Tal como para qualquer novo utilizador, deves apresentar-te à comunidade no fórum “<a href="%s">%s</a>”<br/>
																	Apenas é permitido criar um  único tópico nas apresentações.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES'				=> '<br/>
																	Ao criar o tópico de apresentação, por favor, observa as regras que são exibidas no topo do fórum das apresentações.',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'						=> '<strong><u>As regras repetem-se aqui:</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM'					=> 'Ir para o fórum “%s”',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM'					=> 'Apresenta-te',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'					=> '<br/>Durante a aprovação da apresentação, é possível editar e os moderadores podem responder-te.
																	<br/>O que te irá permitir corrigir a tua apresentação caso seja necessário, conforme os requisitos do fórum.',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'							=> 'Apresentação do Utilizador',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'					=> 'Não existe nenhuma apresentação disponível para este utilizador',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'						=> 'Ver apresentação do utilizador',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'			=> 'A apresentação deste utilizador encontra-se em aprovação',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'							=> 'Ir à apresentação do utilizador',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'							=> 'A apresentação encontra-se em aprovação',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'							=> 'Utilizador sem apresentação disponível',
));
