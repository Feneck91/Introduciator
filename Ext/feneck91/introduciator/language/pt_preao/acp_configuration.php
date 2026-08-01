<?php

/**
 * @package phpBB Extension - Introduciator Extension for phpBB.
 * info_acp_introduciator.php [English]
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
* mode: configuration
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, [
	'INTRODUCIATOR_CP_TITLE'                       => 'Configurações do Introduciator',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'               => 'Permite configurar as definições da extensão.',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'         => 'Forçar o utilizador a apresentar-se:',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN' => 'Quando esta opção está activada, a extensão força o utilizador a publicar a sua própria apresentação antes de poder publicar noutros tópicos.
																			<br/>Quando esta funcionalidade não está activada, todas as outras opções permanecem activas.',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST'         => 'Autorizar a extensão a verificar a eliminação da primeira mensagem de apresentação no fórum de apresentações:',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST_EXPLAIN' => 'Quando esta opção está activada, a extensão impede a eliminação da primeira mensagem de qualquer tópico no fórum de apresentações.
																			<br/>Nem os moderadores ou administradores têm esta permissão para garantir que a primeira mensagem em qualquer tópico de apresentação é realmente a apresentação de um membro do fórum. No entanto, continua a ser possível eliminar o tópico se as permissões o permitirem.
																			<br/>Podes desactivar esta opção mas, neste caso, um membro poderá ter várias apresentações. Activar esta opção é preferível.',
	'INTRODUCIATOR_CP_FORUM_CHOICE'                   => 'O fórum onde o utilizador se deve apresentar:',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'           => 'A extensão irá procurar apenas neste fórum se os utilizadores do fórum se apresentaram.',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'         => 'Opções de aprovação de apresentação:',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN' => 'É usado para forçar a apresentação a ser aprovada por um moderador:<br/>
																			<ul>
																			<li><b>Sem aprovação</b>: não força a apresentação a ser aprovada, deixa o processamento padrão.</li>
																			<li><b>Aprovação simples</b>: força a apresentação a ser aprovada. O utilizador não vê a sua apresentação se não for validada por um moderador (processamento normal é usado para todas as mensagens que usam aprovação).</li>
																			<li><b>Aprovação com capacidade de edição</b>: força a apresentação a ser aprovada. O utilizador pode ver a sua apresentação imediatamente e pode modificá-la. Não pode publicar noutro local enquanto a sua apresentação não for validada por um moderador. Isto permite que moderadores e utilizadores troquem impressões para colocar as mensagens em conformidade antes da validação por um moderador (aprovação de processamento de mensagem incomum). Apenas a edição é permitida. Responder e citar são proibidos.</li>
																			</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'                => 'Sem aprovação',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'                   => 'Aprovação simples',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'         => 'Aprovação com capacidade de edição',
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS' => 'Configuração de grupos e utilizadores',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'                         => 'Usar permissões do phpBB:',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'                 => 'Podes usar as permissões do phpBB ou a configuração desta extensão (forma mais simples mas menos eficiente) para indicar que o utilizador se deve apresentar.<br /><br />Quando a opção "Usar permissões do fórum" é usada, a configuração seguinte é ignorada.',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'                   => 'Usar permissões do fórum',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'               => 'Usar configuração da extensão',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'                  => 'Incluir ou excluir grupos:',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'          => 'Quando "incluir grupos" é seleccionado, apenas os utilizadores dos grupos seleccionados precisam de se apresentar.<br />Quando "excluir grupos" é seleccionado, apenas os utilizadores que não estão nos grupos seleccionados precisam de se apresentar.',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'                   => 'Incluir grupos',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'                   => 'Excluir grupos',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'                         => 'Seleções de grupos:',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'                 => 'Selecciona os grupos que devem ser incluídos ou excluídos.',
	'INTRODUCIATOR_CP_IGNORED_USERS'                           => 'Utilizadores ignorados:',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'                   => 'Utilizadores que não são obrigados a apresentar-se.<br />Introduz um nome de utilizador em cada linha.<br />A opção é usada, por exemplo, para os administradores ou contas de teste.',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'                     => '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'             => 'Nenhum fórum seleccionado',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'             => 'Deves escolher um fórum!',
	'INTRODUCIATOR_CP_LOG_UPDATED'                             => '<strong>Introduciator: definições de configuração atualizadas.</strong>',
	'INTRODUCIATOR_CP_UPDATED'                                 => 'A configuração foi atualizada',
]);
