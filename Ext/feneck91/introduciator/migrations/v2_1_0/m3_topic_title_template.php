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

class m3_topic_title_template extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array('\feneck91\introduciator\migrations\v2_1_0\m2_check_move_duplicate');
	}

	/**
	 * Add the table schema to the database
	 *
	 * @return array
	 * @access public
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'introduciator_explanation' => [
					// Per-language template used to pre-fill (not enforce) the Subject field
					// when a member starts a new introduction topic. Empty = don't pre-fill.
					'topic_title_template' => ['VCHAR:100', ''],
				],
			],
		];
	}

	/**
	 * Drop the column from the database
	 *
	 * @return array
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'introduciator_explanation' => [
					'topic_title_template',
				],
			],
		];
	}
}
