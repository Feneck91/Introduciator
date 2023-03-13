<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\acp;

use feneck91\introduciator\controller\acp_main_controller;

/**
 * Module to manage ACP extension configuration.
 */
class introduciator_module
{
	/**
	 * Constant form key used to verify that the form comes from ACP post.
	 */
	const form_key = 'feneck91/acp_introduciator';

	/**
	 * @var array
	 */
	private static $available_mode = array(
		array('module_name' => 'general'),
		array('module_name' => 'configuration'),
		array('module_name' => 'explanation'),
		array('module_name' => 'statistics'),
	);

	/**
	 *  @var string
	 */
	public $u_action;

	/**
	 * @var string
	 */
	public $tpl_name;

	/**
	 * Main function call
	 *
	 * @param string $id
	 * @param string $mode
	 *
	 * @throws \Exception
	 * @return void
	 * @access public
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @type \phpbb\language\language $language Language object */
		$language = $phpbb_container->get('language');

		if ($this->in_array_field($mode, 'module_name', $this::$available_mode))
		{
			// Load the module language file currently in use
			$language->add_lang('acp_' . $mode, 'feneck91/introduciator');

			// Get an instance of the acp controller
			/** @type acp_main_controller $acp_controller */
			$acp_controller = $phpbb_container->get('feneck91.introduciator.controller.acp_' . $mode);

			if ($acp_controller instanceof acp_main_controller)
			{
				// Make the $u_action url available in the admin controller
				$acp_controller->set_page_url($this->u_action);
			}

			// Load a template from adm/style for our ACP page
			$this->tpl_name = 'introduciator_acp_page_' . strtolower($mode);

			// Add a secret token to the form
			// This functions adds a secret token to any form, a token which should be checked after
			// submission with the check_form_key function to ensure that the received data is the same as the submitted.
			add_form_key(self::form_key);

			/** @type \phpbb\request\request $request Request object */
			$request = $phpbb_container->get('request');
			// Requests
			$action = $request->variable('action', '');

			$acp_controller->do_action($mode, $action);
		}
		else
		{
			trigger_error('NO_MODE', E_USER_ERROR);
		}
	}

	/**
	 * Check if value is in array
	 *
	 * @param mixed $needle
	 * @param mixed $needle_field
	 * @param array $haystack
	 *
	 * @return bool
	 * @access private
	 */
	private function in_array_field($needle, $needle_field, $haystack)
	{
		foreach ($haystack as $item)
		{
			if (isset($item[$needle_field]) && $item[$needle_field] === $needle)
			{
				return true;
			}
		}

		return false;
	}
}
