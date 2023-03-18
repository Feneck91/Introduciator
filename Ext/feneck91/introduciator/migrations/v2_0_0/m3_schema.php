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

class m3_schema extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array('\feneck91\introduciator\migrations\v2_0_0\m2_acp_module');
	}

	/**
	 * Run migration if introduciator_groups table exists
	 *
	 * @return bool Is effectively installed?
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'introduciator_groups');
	}

	/**
	 * Add the table schema to the database
	 *
	 * Only add the introduciator group table is added
	 *
	 * Return an array of table schema to create / update
	 *
	 * @return array
	 * @access public
	 */
	public function update_schema()
	{
		return [
			// Add Groups list table
			'add_tables' => [
				$this->table_prefix . 'introduciator_groups' => [
					'COLUMNS' => [
						'fk_group'	=> ['UINT', null],
					],
				],
				$this->table_prefix . 'introduciator_explanation' => [
					'COLUMNS'		=> [
						'id'							=> ['UINT', null, 'auto_increment'],
						'lang'							=> ['VCHAR:30', ''],
						'message_title'					=> ['MTEXT_UNI', ''],
						'message_title_uid'				=> ['VCHAR:8', ''],
						'message_title_bitfield'		=> ['VCHAR:255', ''],
						'message_title_bbcode_options'	=> ['VCHAR:255', ''],
						'message_text'					=> ['MTEXT_UNI', ''],
						'message_text_uid'				=> ['VCHAR:8', ''],
						'message_text_bitfield'			=> ['VCHAR:255', ''],
						'message_text_bbcode_options'	=> ['VCHAR:255', ''],
						'rules_title'					=> ['MTEXT_UNI', ''],
						'rules_title_uid'				=> ['VCHAR:8', ''],
						'rules_title_bitfield'			=> ['VCHAR:255', ''],
						'rules_title_bbcode_options'	=> ['VCHAR:255', ''],
						'rules_text'					=> ['MTEXT_UNI', ''],
						'rules_text_uid'				=> ['VCHAR:8', ''],
						'rules_text_bitfield'			=> ['VCHAR:255', ''],
						'rules_text_bbcode_options'		=> ['VCHAR:255', ''],
					],
					'PRIMARY_KEY'	=> 'id',
				],
			],
		];
	}

	/**
	 * Drop the Introduciator groups table schema from the database.
	 *
	 * @return array Array of table schema to revert
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			// Remove table
			'drop_tables' => [
				$this->table_prefix . 'introduciator_groups',
				$this->table_prefix . 'introduciator_explanation',
			],
		];
	}
}