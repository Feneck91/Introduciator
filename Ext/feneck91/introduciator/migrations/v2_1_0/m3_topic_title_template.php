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
		$table = $this->table_prefix . 'introduciator_explanation';

		// Some legacy installations have the groups table (so the original
		// schema migration was considered installed) but not the explanation
		// table. Create the complete table before trying to add a column to it.
		if (!$this->db_tools->sql_table_exists($table))
		{
			return [
				'add_tables' => [
					$table => \feneck91\introduciator\migrations\v2_0_0\m3_schema::explanation_table_schema(),
				],
			];
		}

		return [
			'add_columns' => [
				$table => [
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
