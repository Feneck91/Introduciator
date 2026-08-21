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

class m1_topic_mode extends \phpbb\db\migration\migration
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
	 * Run migration if introduciator_fk_topic_id config doesn't exists
	 *
	 * @return bool Is effectively installed?
	 */
	public function effectively_installed()
	{
		return isset($this->config['introduciator_fk_topic_id']);
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
			// 0 = introduce in a dedicated forum (one topic per user, existing behaviour)
			// 1 = introduce as a post inside a single shared topic
			['config.add', ['introduciator_mode', 0]],
			['config.add', ['introduciator_fk_topic_id', 0]],
		];
	}
}
