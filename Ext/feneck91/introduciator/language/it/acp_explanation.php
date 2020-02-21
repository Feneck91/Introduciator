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
* mode: explanation
* Info: language keys are prefixed with 'INTRODUCIATOR_EP_' for 'INTRODUCIATOR_EXPLANATION_PAGES_'
*/
$lang = array_merge($lang, array(
	// Titles
	'INTRODUCIATOR_EP_TITLE'										=> 'Introduzione impostazioni di configurazione',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'								=> 'Permette di configurare le impostazioni della MOD.',

	// Settings: page configuration
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'						=> 'Spiegazioni pagina di configurazione',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'									=> 'Visualizza Pagina spiegazione:',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'							=> 'Questa opzione viene utilizzata per visualizzare una pagina di spiegazione se l’utente sta cercando di inserire il messaggio in un altro forum invece del forum per le presentazioni.',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'						=> 'Visualizza le regole del Forum per le introduzioni:',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'				=> 'Utilizzato per visualizzare le regole per il forum per le introduzioni sulla pagina di spiegazione.',

	// Settings: page text configuration
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'					=> 'Spiegazioni pagina ?????? di configurazione',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN'			=> 'Per tutti i campi successivi, è possibile utilizzare:<br/>
																		<ul>
																		<li><b>%forum_name%</b>: NOME del forum per la presentazione</li>
																		<li><b>%forum_url%</b>: URL del Forum per la presentazione</li>
																		<li><b>%forum_post%</b>: URL da scrivere il uovo post nel forum per le presentazioni</li>
																		</ul>
																		È possibile utilizzare i BBcode per fare i messaggi.<br/>
																		<br/>
																		<u>Esempi:</u>
																		<ul>
																		<li>Fare Link al forum per le presentazioni: <i>[url=<b>%forum_url%</b>]Clicca qui per andare al forum ’<b>%forum_name%</b>’[/url]</i>
																		<li>Fare link per creare l’argomento e forum per le presentazioni: <i>[url=<b>%forum_post%</b>]Clicca qui per creare topic nel forum ’<b>%forum_name%</b>’[/url]</i>
																		</ul>
																		<br/>',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'								=> 'Titolo per la pagina di spiegazione:',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'						=> 'Default = <b>%explanation_title%</b><br/>È possibile modificare questo testo con il proprio.',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'									=> 'Testo per la pagina di Spiegazione:',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'							=> 'Default = <b>%explanation_text%</b><br/>È possibile modificare questo testo con il proprio.',
	'INTRODUCIATOR_EP_RULES_TITLE'									=> 'Titolo spiegazione regole:',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'							=> 'Default = <b>%rules_title%</b><br/>È possibile modificare questo testo con il proprio.',
	'INTRODUCIATOR_EP_RULES_TEXT'									=> 'Testo delle regole per il forum per le presentazioni:',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'							=> 'Default = <b>%rules_text%</b><br/>Per impostazione predefinita, %rules_text% è sostituito dalle regole per il forum per le presentazioni.<br/>È possibile modificare questo testo con il proprio.',

	// Logs
	'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED'						=> '<strong>?????</strong>',

	// Confirm box
	'INTRODUCIATOR_EP_UPDATED'										=> '????La configurazione è stata aggiornata con successo',

));
