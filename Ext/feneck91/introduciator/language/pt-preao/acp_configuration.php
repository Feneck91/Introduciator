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
	// Titles
	'INTRODUCIATOR_CP_TITLE'										=> 'Configuração do Introduciator',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'								=> 'Permite configurar a extensão.',

	// Settings: general
	'INTRODUCIATOR_CP_EXTENSION_ACTIVATED'						=> 'Activar extensão:',
	'INTRODUCIATOR_CP_EXTENSION_ACTIVATED_EXPLAIN'			=> 'Usado para activar ou desactivar esta extensão.',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'						=> 'Força o utilizador a apresentar-se:',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN'			=> 'Quando esta opção se encontra activa, a extensão força o utilizador a apresentar-se no tópico respectivo antes de poder participar noutros tópicos.
																				<br/>Quando esta funcionalidade não se encontra activa, todas as outras opções continuam a funcionar.',
	'INTRODUCIATOR_CP_CHECK_DEL_FIRST_POST'					=> 'Autoriza a extensão a verificar a remoção da primeira mensagem da apresentação no fórum das apresentações:',
	'INTRODUCIATOR_CP_CHECK_DEL_FIRST_POST_EXPLAIN'			=> 'Quando esta opção se encontra activa, a extensão previne que a primeira mensagem de qualquer tópico que se encontra no fórum das apresentações seja removido.
																				<br/>Mesmo moderadores ou administradores não têm permissões para garantir que a primeira mensagem de qualquer tópico de apresentação é a apresentação do utilizador. No entanto, é possível apagar o tópico caso haja permissões para isso.
																				<br/>Podes desactivar esta opção, mas irás permitir que o utilizador possa criar múltiplas apresentações. É recomendado ter esta opção activa.',
	'INTRODUCIATOR_CP_FORUM_CHOICE'								=> 'O fórum onde o utilizador se deve apresentar:',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'					=> 'A extensão irá procurar apenas neste fórum por apresentações.',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'					=> 'Opções de aprovação das apresentações:',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN'		=> 'É usado para forçar que a apresentação seja aprovada por um moderador:<br/>
																				<ul>
																				<li><b>Sem aprovação</b>: a mensagem segue normalmente sem que haja necessidade de aprovar.</li>
																				<li><b>Aprovação simples</b>: força a apresentação de ser aprovada. O utilizador não consegue ver a sua apresentação até ser validada por um moderador (processo normal usado nas aprovações).</li>
																				<li><b>Aprovação com possibilidade de editar</b>: força a apresentação de ser aprovada. O utilizador consegue ver a sua apresentação imediatamente e pode inclusive modificá-la. Continua sem poder criar tópicos ou mensagens enquanto a sua apresentação não é aprovada por um moderador. Isto permite que os moderadores e os utilizadors troquem mensagens até que a apresentação esteja nos conformes antes de ser validado pelo moderador (processo de aprovação pouco comum). Apenas edição é permitida. Responder e citar não são possíveis.</li>
																				</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'				=> 'Sem aprovação',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'					=> 'Aprovação simples',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'		=> 'Aprovação com possibilidade de editar',

	// Settings: groups and users
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'	=> 'Configuração de grupos e utilizadores',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'									=> 'Usar permissões phpBB:',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'						=> 'Podes usar tanto as permissões do phpBB ou configuração desta extensão (modo mais simples mas menos eficiente) para indicar que o utilizador precisa de se apresentar.',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'							=> 'Usare permissões dos fóruns',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'						=> 'Usar configuração da extensão',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'							=> 'Incluir ou excluir grupos:',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'				=> 'Quando « Incluir grupos » está seleccionado, apenas utilizadores desses grupos precisam de se apresentar.<br />Quando « Excluir grupos » está seleccionado, apenas utilizadores que não estão nesses grupos é que precisam de se apresentar.',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'							=> 'Incluir grupos',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'							=> 'Excluir grupos',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'									=> 'Seleção de Grupos:',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'						=> 'selecciona os grupos que devem ser incluídos ou excluídos.',
	'INTRODUCIATOR_CP_IGNORED_USERS'										=> 'Ignorar utilizadores:',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'							=> 'Utilizadores que não precisam de se apresentar.<br />Coloca os nomes de utilizador um por linha.<br />Esta opção serve para colocar os administradores ou contas de teste.',

	// Messages
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'								=> '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'					=> 'Nenhum fórum seleccionado, apenas para quando a extensão está desactivada',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'					=> 'Quando a extensão se encontra activa, deves seleccionar um fórum!',

	// Logs
	'INTRODUCIATOR_CP_LOG_UPDATED'								=> '<strong>Introduciator: configuração actualizada com sucesso.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'										=> 'A configuração foi actualizada com sucesso',
]);
