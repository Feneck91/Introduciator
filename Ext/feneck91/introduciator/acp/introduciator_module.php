<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\acp;

use feneck91\introduciator\controller\introduciator_acp_main;

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
	 * @var array
	 */
	private $module_info;
	
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

		if ($this->in_array_field($mode, 'module_name', $this::$available_mode))
		{
			$this->module_info = $this->array_value($mode, 'module_name', $this::$available_mode);

			// Get an instance of the acp controller
			/** @type \feneck91.introduciator.controller.introduciator_acp_main $acp_controller */
			$acp_controller = $phpbb_container->get('feneck91.introduciator.controller.acp_' . $mode);

			// Make the $u_action url available in the admin controller
			$acp_controller->set_page_url($this->u_action);

			// Load a template from adm/style for our ACP page
			$this->tpl_name = 'introduciator_acp_page_' . strtolower($mode);

			// Add a secret token to the form
			// This functions adds a secret token to any form, a token which should be checked after
			// submission with the check_form_key function to ensure that the received data is the same as the submitted.
			add_form_key(introduciator_module::form_key);
			
			$this->switch_mode($id, $mode, $acp_controller);
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
		unset($item);

		return false;
	}

	/**
	 * Return the selected array if value is in array
	 *
	 * @param mixed $needle
	 * @param mixed $needle_field
	 * @param array $haystack
	 *
	 * @return array
	 * @access private
	 */
	private function array_value($needle, $needle_field, $haystack)
	{
		foreach ($haystack as $item)
		{
			if (isset($item[$needle_field]) && $item[$needle_field] === $needle)
			{
				return $item;
			}
		}
		unset($item);

		return array();
	}
	
	/**
	 * Switch to the mode selected.
	 *
	 * @param string                    $id
	 * @param string                    $mode
	 * @param introduciator_acp_main    $acp_controller
	 *
	 * @throws \Exception
	 * @return void
	 * @access private
	 */
	private function switch_mode($id, $mode, $acp_controller)
	{
		global $phpbb_container;

		/** @type \phpbb\request\request $request Request object */
		$request = $phpbb_container->get('request');

		// Requests
		$action = $request->variable('action', '');

		switch ($mode)
		{
			case 'general':
				$this->do_action($id, $mode, $action, $acp_controller);
			break;
		
			case 'configuration':
				$this->do_action($id, $mode, $action, $acp_controller);
			break;

			case 'explanation':
				$this->do_action($id, $mode, $action, $acp_controller);
			break;
		
			case 'statistics':
				$this->do_action($id, $mode, $action, $acp_controller);
			break;

			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}
	}
	
	/**
	 * Performs action requested by the module
	 *
	 * @param string                    $id
	 * @param string                    $mode
	 * @param string                    $action
	 * @param introduciator_acp_main    $acp_controller
	 *
	 * @throws \Exception
	 * @return void
	 * @access private
	 */
	private function do_action($id, $mode, $action, $acp_controller)
	{
		// Manage the action in the specific controller
		$acp_controller->do_action($mode, $action);
	}
}