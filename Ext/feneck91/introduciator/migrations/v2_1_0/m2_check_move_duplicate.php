<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2026 Feneck91
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\migrations\v2_1_0;

class m2_check_move_duplicate extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array('\feneck91\introduciator\migrations\v2_1_0\m1_topic_mode');
	}

	/**
	 * Run migration if introduciator_is_check_move_duplicate config doesn't exists
	 *
	 * @return bool Is effectively installed?
	 */
	public function effectively_installed()
	{
		return isset($this->config['introduciator_is_check_move_duplicate']);
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
			// When on, moving a topic (MCP, QuickMod, or the ACP's delete-user topic reassignment)
			// into the introduce forum is blocked if its poster already has a different topic there.
			['config.add', ['introduciator_is_check_move_duplicate', 1]],
		];
	}
}
