<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\helper;

class extension_manager_helper extends \phpbb\extension\manager
{
	/**
	 *  Extension name
	 */
	const EXT_NAME = 'feneck91/introduciator';

	/**
	 *
	 * @var type
	 */
	protected $ext_meta;

	/**
	 * Get extension metadata
	 *
	 * @return array
	 * @access public
	 */
	public function get_ext_meta()
	{
		return empty($this->ext_meta) ? $this->load_metadata() : $this->ext_meta;
	}

	/**
	 * Load metadata for this extension
	 *
	 * @return array
	 * @access private
	 */
	private function load_metadata()
	{
		$md_manager = $this->create_extension_metadata_manager($this::EXT_NAME);

		try
		{
			$this->ext_meta = $md_manager->get_metadata('all');
		}
		catch (\phpbb\extension\exception $e)
		{
			trigger_error($e, E_USER_WARNING);
		}

		return $this->ext_meta;
	}
}
