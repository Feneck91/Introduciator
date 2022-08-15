<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\migrations\v2_0_0;

class v2_0_0_schema extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencie.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array('\feneck91\introduciator\migrations\v2_0_0\v2_0_0_data');
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
		return array(
			// Add Groups list table
			'add_tables' => array(
				$this->table_prefix . 'introduciator_groups' => array(
					'COLUMNS' => array(
						'fk_group'			=> array('UINT', null),
					),
				),
				$this->table_prefix . 'introduciator_explanation' => array(
					'COLUMNS'		=> array(
						'id'							=> array('UINT', null, 'auto_increment'),
						'lang'							=> array('VCHAR:30', ''),
						'message_title'					=> array('MTEXT_UNI', ''),
						'message_title_uid'				=> array('VCHAR:8', ''),
						'message_title_bitfield'		=> array('VCHAR:255', ''),
						'message_title_bbcode_options'	=> array('VCHAR:255', ''),
						'message_text'					=> array('MTEXT_UNI', ''),
						'message_text_uid'				=> array('VCHAR:8', ''),
						'message_text_bitfield'			=> array('VCHAR:255', ''),
						'message_text_bbcode_options'	=> array('VCHAR:255', ''),
						'rules_title'					=> array('MTEXT_UNI', ''),
						'rules_title_uid'				=> array('VCHAR:8', ''),
						'rules_title_bitfield'			=> array('VCHAR:255', ''),
						'rules_title_bbcode_options'	=> array('VCHAR:255', ''),
						'rules_text'					=> array('MTEXT_UNI', ''),
						'rules_text_uid'				=> array('VCHAR:8', ''),
						'rules_text_bitfield'			=> array('VCHAR:255', ''),
						'rules_text_bbcode_options'		=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),
		);
	}

	/**
	 * Drop the Introduciator groups table schema from the database.
	 *
	 * @return array Array of table schema to revert
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			// Remove table
			'drop_tables' => array(
				$this->table_prefix . 'introduciator_groups',
				$this->table_prefix . 'introduciator_explanation',
			),
		);
	}
}