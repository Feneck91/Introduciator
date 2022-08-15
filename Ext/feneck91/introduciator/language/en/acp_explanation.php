<?php

/**
 * info_acp_introduciator.php [English]
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
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
	'INTRODUCIATOR_EP_TITLE'										=> 'Introduciator explanation’s page settings',
	'INTRODUCIATOR_EP_TITLE_EXPLAIN'								=> 'Allow to configure the Introduciator’s explanation’s page settings.',

	// Settings: page configuration
	'INTRODUCIATOR_EP_GENERAL_SETTINGS_TITLE'						=> 'Explanations page configuration',
	'INTRODUCIATOR_EP_DISPLAY_PAGE'									=> 'Display explanation page:',
	'INTRODUCIATOR_EP_DISPLAY_PAGE_EXPLAIN'							=> 'This option is used to display an explanation page if the user is trying to post into another forum than the forum for introductions.',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED'						=> 'Display rules of the forum for introductions:',
	'INTRODUCIATOR_EP_DISPLAY_RULES_ENABLED_EXPLAIN'				=> 'Used to display the rules for the forum for introductions on the explanation page.',

	// Settings: page text configuration
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE'					=> 'Explanations text page configuration',
	'INTRODUCIATOR_EP_GENERAL_OPTIONS_TEXTS_TITLE_EXPLAIN'			=> 'For all next fields, you can use:<br/>
																		<ul>
																		<li><b>%forum_name%</b>: name of the forum for introductions</li>
																		<li><b>%forum_url%</b>: url to the forum for introductions</li>
																		<li><b>%forum_post%</b>: url to write new post into the forum for introductions</li>
																		</ul>
																		You can use BBcodes to make messages.<br/>
																		<br/>
																		<u>Examples:</u>
																		<ul>
																		<li>Make link to forum for introductions: <i>[url=<b>%forum_url%</b>]Click here to go to forum ’<b>%forum_name%</b>’[/url]</i>
																		<li>Make link to create topic into forum for introductions: <i>[url=<b>%forum_post%</b>]Click here to create topic into the forum ’<b>%forum_name%</b>’[/url]</i>
																		</ul>
																		<br/>',
	'INTRODUCIATOR_EP_MESSAGE_TITLE'								=> 'Explanation page title:',
	'INTRODUCIATOR_EP_MESSAGE_TITLE_EXPLAIN'						=> 'Default = <b>%explanation_title%</b><br/>You can change this text to your own.',
	'INTRODUCIATOR_EP_MESSAGE_TEXT'									=> 'Explanation page text:',
	'INTRODUCIATOR_EP_MESSAGE_TEXT_EXPLAIN'							=> 'Default = <b>%explanation_text%</b><br/>You can change this text to your own.',
	'INTRODUCIATOR_EP_RULES_TITLE'									=> 'Explanation rules title:',
	'INTRODUCIATOR_EP_RULES_TITLE_EXPLAIN'							=> 'Default = <b>%rules_title%</b><br/>You can change this text to your own.',
	'INTRODUCIATOR_EP_RULES_TEXT'									=> 'Text of the rules for the forum for introductions:',
	'INTRODUCIATOR_EP_RULES_TEXT_EXPLAIN'							=> 'Default = <b>%rules_text%</b><br/>By default, %rules_text% is replaced by rules for the forum for introductions.<br/>You can change this text to your own.',

	// Logs
	'INTRODUCIATOR_EP_LOG_EXPLANATION_UPDATED'						=> '<strong>Introduciator: explanation’s settings updated.</strong>',

	// Confirm box
	'INTRODUCIATOR_EP_UPDATED'										=> 'The explanation’s page settings has been updated',
));
