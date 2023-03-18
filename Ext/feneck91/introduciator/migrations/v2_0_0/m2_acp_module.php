<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) 2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\migrations\v2_0_0;

class m2_acp_module extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array('\feneck91\introduciator\migrations\v2_0_0\m1_data');
	}

	/**
	 * Run migration if introduciator_fk_forum_id config doesn't exists
	 *
	 * @return bool Is effectively installed?
	 */
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
				FROM ' . $this->table_prefix . "modules
				WHERE module_class = 'acp'
				 AND module_langname = 'ACP_INTRODUCIATOR_EXTENSION'";
		$result = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id;
	}

	/**
	 * Update data of the database.
	 *
	 * @return array Array of elements to update.
	 * @access public
	 */
	public function update_data()
	{
		return [
			// Add the module in ACP under the customise tab
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_INTRODUCIATOR_EXTENSION']],

			// Add a new category named ACP_INTRODUCIATOR_EXTENSION to ACP_CAT_DOT_MODS (under tab 'extensions' in ACP)
			['module.add', [
					'acp',
					'ACP_INTRODUCIATOR_EXTENSION',
					[
						'module_basename'	=> '\feneck91\introduciator\acp\introduciator_module',
						'modes' => [
							//---------------------------------------------------------------------
							// Creation of ACP sub categories under Introduciator extension into Extensions tab
							'general',
							'configuration',
							'explanation',
							'statistics',
							// Creation of ACP sub categories under Introduciator extension into Extensions tab
							//---------------------------------------------------------------------
							],
					],
				]
			],
		];
	}
}