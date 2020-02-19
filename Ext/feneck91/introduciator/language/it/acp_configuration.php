<?php
/**
 * info_acp_introduciator.php [Italian]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
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

/**
* mode: configuration
* Info: language keys are prefixed with 'INTRODUCIATOR_CP_' for 'INTRODUCIATOR_CONFIGURATION_PAGES_'
*/
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_CP_TITLE'										=> 'Introduzione impostazioni di configurazione',
	'INTRODUCIATOR_CP_TITLE_EXPLAIN'								=> 'Permette di configurare le impostazioni della MOD.',

	// Settings: general
	'INTRODUCIATOR_CP_EXTENSION_ACTIVATED'							=> 'Abilita MOD',
	'INTRODUCIATOR_CP_EXTENSION_ACTIVATED_EXPLAIN'					=> 'Utilizzato per abilitare o disabilitare questa MOD.',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE'							=> 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx Force the user to introduce himself',
	'INTRODUCIATOR_CP_MANDATORY_INTRODUCE_EXPLAIN'					=> 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx When this option is enabled, the extension force the user to post his own introduce before being allowed to post in other topics.
																			xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx <br/>Il this feature is not enabled, all other options remain active.',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST'							=> 'Autorizzo il MOD per verificare l’eliminazione del primo post introduzione nel forum per le presentazioni',
	'INTRODUCIATOR_CP_CHECK_DEL_1ST_POST_EXPLAIN'					=> 'Quando questa opzione è abilitata, il MOD impedisce il primo post in qualsiasi argomento nel forum per le presentazioni dall’eliminazione.
																			<br/>Anche i moderatori o gli amministratori non hanno questo permesso per essere sicuri che il primo messaggio in qualsiasi argomento introduttivo è davvero l’introduzione di un membro del forum. Tuttavia, rimane possibile cancellare l’argomento se i permessi lo consentono.
																			<br/>È possibile disattivare questa opzione, ma in questo caso un utente sarà in grado di avere diverse presentazioni. L’attivazione di questa opzione è preferibile.',
	'INTRODUCIATOR_CP_FORUM_CHOICE'									=> 'Il forum in cui l’utente deve introdurre se stesso/se stessa',
	'INTRODUCIATOR_CP_FORUM_CHOICE_EXPLAIN'							=> 'Il MOD cercherà solo in questo forum se gli utenti del forum hanno introdotto loro stessi.',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL'						=> 'Opzioni di approvazione Introduzione',
	'INTRODUCIATOR_CP_POSTING_APPROVAL_LEVEL_EXPLAIN'				=> 'Viene utilizzato per forzare l’introduzione e per essere approvato da un moderatore:<br/>
																			<ul>
																			<li><b>Nessuna approvazione</b>: non forzare l’introduzione e per essere approvato, lascia il processo di default.</li>
																			<li><b>Approvazione semplice</b>: forza l’introduzione da approvare. L’utente non vede il suo/la sua introduzione, se non viene convalidato da un moderatore (normale elaborazione viene utilizzato per tutti i messaggi che utilizzano l’approvazione).</li>
																			<li><b>Approvazione con possibilità di modificare</b>: forza l’introduzione da approvare. L’utente può vedere la sua introduzione immediatamente e può modificarlo. Lui/Lei non possono inserire i messaggi/argomenti altrove mentre la sua introduzione non viene convalidata da un moderatore. Questo permette ai moderatori e utenti di scambiare e rendere i messaggi/argomenti in regola prima della convalida da parte di un moderatore (messaggio inappropriato elaborazione di approvazione). Solo edizione è permesso. risposta e quote sono vietati.</li>
																			</ul>',
	'INTRODUCIATOR_CP_TEXT_POSTING_NO_APPROVAL'						=> 'Nessuna approvazione',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL'						=> 'Approvazione semplice',
	'INTRODUCIATOR_CP_TEXT_POSTING_APPROVAL_WITH_EDIT'				=> 'Approvazione con possibilità di modifica',	

	// Settings: groups and users
	'INTRODUCIATOR_CP_GENERAL_OPTIONS_MANAGE_GROUPS_AND_USERS'		=> 'Configurazione gruppi e utenti',
	'INTRODUCIATOR_CP_USE_PERMISSIONS'								=> 'Usa i permessi di phpBB',
	'INTRODUCIATOR_CP_USE_PERMISSIONS_EXPLAIN'						=> 'È possibile utilizzare i permessi di phpBB per questa configurazione MOD (modo più semplice ma meno efficace) per indicare che l’utente deve introdurre se stesso/se stessa.<br /><br />Quando si « Usa permessi forum » l’opzione viene utilizzata, la configurazione successiva viene ignorata.',
	'INTRODUCIATOR_CP_USE_PERMISSION_OPTION'						=> 'Utilizza permessi forum',
	'INTRODUCIATOR_CP_NOT_USE_PERMISSION_OPTION'					=> 'Utilizza la configurazione MOD',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS'						=> 'Includere o escludere gruppi',
	'INTRODUCIATOR_CP_INCLUDE_EXCLUDE_GROUPS_EXPLAIN'				=> 'Quando «Includi i gruppi» è selezionato, solo gli utenti dei gruppi selezionati devono presentarsi.<br />Quando «Escludi i gruppi» è selezionato, solo gli utenti che non sono in gruppi selezionati devono presentarsi.',
	'INTRODUCIATOR_CP_INCLUDE_GROUPS_OPTION'						=> 'Includi i gruppi',
	'INTRODUCIATOR_CP_EXCLUDE_GROUPS_OPTION'						=> 'Escludi i gruppi',
	'INTRODUCIATOR_CP_SELECTED_GROUPS'								=> 'Selezione Gruppi',
	'INTRODUCIATOR_CP_SELECTED_GROUPS_EXPLAIN'						=> 'Seleziona i gruppi che dovrebbero essere inclusi o esclusi.',
	'INTRODUCIATOR_CP_IGNORED_USERS'								=> 'Utenti ignorati',
	'INTRODUCIATOR_CP_IGNORED_USERS_EXPLAIN'						=> 'Gli utenti che non sono tenuti ad introdurre loro stessi.<br />Inserisci un solo nome utente su ciascuna riga.<br />L’opzione viene utilizzata, ad esempio, per gli amministratori o gli account di prova.',

	// Messages
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE'							=> '',
	'INTRODUCIATOR_CP_MSG_NO_FORUM_CHOICE_TOOLTIP'					=> 'Nessun Forum selezionato, utilizzare solo quando la MOD è disabilitata',
	'INTRODUCIATOR_CP_MSG_ERROR_MUST_SELECT_FORUM'		 			=> 'Quando questa MOD è abilitata, si dovrebbe scegliere un forum!',
	'INTRODUCIATOR_CP_MSG_NO_UPDATE_INFO_FOUND'						=> 'Nessuna informazione e aggiornamento disponibile',

	// Logs
	'INTRODUCIATOR_CP_LOG_UPDATED'									=> '<strong>Introduzione: ???????? aggiornamento impostazioni.</strong>',

	// Confirm box
	'INTRODUCIATOR_CP_UPDATED'										=> 'La configurazione è stata aggiornata con successo',
));
