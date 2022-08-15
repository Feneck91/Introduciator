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

class m1_data extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencie.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320rc2'];
	}

	/**
	 * Run migration if introduciator_fk_forum_id config doesn't exists
	 *
	 * @return bool Is effectively installed?
	 */
	public function effectively_installed()
	{
		return isset($this->config['introduciator_fk_forum_id']);
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
			// Introduciator Settings
			['config.add', ['introduciator_posting_approval_level', 0]],
			['config.add', ['introduciator_allow', '0']],
			['config.add', ['introduciator_fk_forum_id', 0]],
			['config.add', ['introduciator_is_introduction_mandatory', true]],
			['config.add', ['introduciator_is_check_delete_first_post', true]],
			['config.add', ['introduciator_is_explanation_enabled', false]],
			['config.add', ['introduciator_is_use_permissions', true]],
			['config.add', ['introduciator_is_include_groups', true]],
			['config.add', ['introduciator_ignored_users', '']],
			['config.add', ['introduciator_is_explanation_display_rules', true]],

			// Misc Settings
			['config.add', ['introduciator_install_date', time()]],
		];
	}
}