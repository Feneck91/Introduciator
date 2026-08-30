<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\helper;

use phpbb\extension\manager;

/**
 * Reads this extension's own composer.json metadata, for the ACP General page.
 *
 * Wraps phpBB's extension manager rather than extending it: subclassing would mean repeating
 * the core constructor's argument list in our service definition, and any change to it upstream
 * would break the extension at container compile time.
 */
class extension_manager_helper
{
	/**
	 *  Extension name
	 */
	const EXT_NAME = 'feneck91/introduciator';

	/**
	 * @var \phpbb\extension\manager phpBB extension manager
	 */
	protected $ext_manager;

	/**
	 *
	 * @var array Metadata for this extension
	 */
	protected $ext_meta;

	/**
	 * Constructor
	 *
	 * @param \phpbb\extension\manager $ext_manager phpBB extension manager
	 *
	 * @access public
	 */
	public function __construct(manager $ext_manager)
	{
		$this->ext_manager = $ext_manager;
	}

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
		$md_manager = $this->ext_manager->create_extension_metadata_manager(self::EXT_NAME);

		$this->ext_meta = [];

		try
		{
			$this->ext_meta = $md_manager->get_metadata('all');
		}
		catch (\phpbb\extension\exception $e)
		{
			// Only the message: casting the exception itself would print its stack trace,
			// and with it absolute server paths, into the ACP.
			trigger_error($e->getMessage(), E_USER_WARNING);
		}

		return $this->ext_meta;
	}
}
