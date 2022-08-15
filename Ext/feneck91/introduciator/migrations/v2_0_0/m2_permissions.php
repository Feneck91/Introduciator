<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\migrations\v2_0_0;

class m2_permissions extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencie.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return ['\feneck91\introduciator\migrations\v2_0_0\m1_data'];
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
			// Add a new category named ACP_INTRODUCIATOR_EXTENSION to ACP_CAT_DOT_MODS (under tab 'extensions' in ACP)
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INTRODUCIATOR_EXTENSION',
				// Creation of ACP sub caterories under Introduciator extension into Extensions tab
				[
					'module_basename'	=> '\feneck91\introduciator\acp\introduciator_module',
					'modes'	  			=> [
						'general',
						'configuration',
						'explanation',
						'statistics',
					],
				],
			]],
		];
	}
}