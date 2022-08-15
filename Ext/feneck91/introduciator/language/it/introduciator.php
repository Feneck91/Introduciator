<?php

/**
 * introduciator.php [Italian]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) Traduzione MOD by Galandas (Rey) 2016 www.phpbb3world.altervista.org/
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

/*
* General messages
*/
$lang = array_merge($lang, array(
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION'			=> 'Il tuo messaggio di introduzione è in attesa di approvazione, si prega di attendere.',
	'INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT'	=> 'Durante l’approvazione del messaggio di introduzione, e solo permesso la modifica del mesaggio.',
	'INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE'				=> 'Non è consentito introdurre te stesso più di una volta!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST'			=> 'Non è consentito di eliminare il primo messaggio della vostra introduzione!',
	'INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST'				=> 'Non è consentito di eliminare il primo post di questa introduzione! È possibile eliminare questa introduzione eliminando il topic.',
	'INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM'				=> 'Si prega di introdurre te stesso in un topic: %s',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'					=> '<strong>Per essere in grado di pubblicare, <u>devi</u> introdurre/presentare te stesso</strong>',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT'					=> 'Come per ogni nuovo utente, è necessario presentarsi agli altri membri del “<a href="%forum_url%">%forum_name%</a>” forum<br/>
																	è solo permesso un nuovo argomento nel forum per le presentazioni.',
	'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES'				=> '<br/>
																	Quando si crea l’argomento introduzione, osservare le seguenti regole che vengono anche visualizzate nella parte superiore del forum per le presentazioni.',
	'INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'						=> '<strong><u>Le regole sono ripetute qui:</u></strong>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM'					=> '<a href="%forum_url%">Vai al “%forum_name%” forum ora cliccando su questo link</a>',
	'INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM'					=> '<a href="%forum_post%">Introduci te stesso ora cliccando su questo link</a>',
	'INTRODUCIATOR_EXT_POST_APPROVAL_NOTIFY'					=> '<br/>Durante l’approvazione della presentazione, il topic rimane modificabile e i moderatori possono rispondere a voi.
																	<br/>Questo vi permetterà di renderla conforme ai requisiti del forum se necessario.',

	'INTRODUCIATOR_MEMBER_INTRODUCTION'							=> 'Introduzione Utenti',
	'INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION'					=> 'Nessuna introduzione disponibile per questo utente',
	'INTRODUCIATOR_TOPIC_VIEW_PRESENTATION'						=> 'Vedi l’introduzione degli utenti',
	'INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION'			=> 'L’introduzione di questo utente è in attesa di approvazione',

	'INTRODUCIATOR_VIEW_MEMBER_GOTO'							=> 'Vai a introduzione utenti',
	'INTRODUCIATOR_VIEW_MEMBER_PENDING'							=> 'L’introduzione dell’utente è in attesa di approvazione',
	'INTRODUCIATOR_VIEW_MEMBER_NO_GOTO'							=> 'Nessuna introduzione disponibile per questo utente',
));
