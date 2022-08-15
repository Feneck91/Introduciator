<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
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

			// Add admin permissions
			['permission.add', ['a_introduciator_manage', true]],

			// Add user permissions
			['permission.add', ['u_must_introduce', true]],

			// Set permissions users
			['permission.permission_set', ['ADMINISTRATORS', 'u_must_introduce', 'group', false]], // Set to never for adminitrators
			['permission.permission_set', ['GLOBAL_MODERATORS', 'u_must_introduce', 'group']],
			['permission.permission_set', ['REGISTERED', 'u_must_introduce', 'group']],
			['permission.permission_set', ['NEWLY_REGISTERED', 'u_must_introduce', 'group']],

			// Set permissions administration
			['permission.permission_set', ['ADMINISTRATORS', 'a_introduciator_manage', 'group']],

			// Global user role permissions for user mask
			['if', [
				['permission.role_exists', ['ROLE_USER_STANDARD']],
				['permission.permission_set', ['ROLE_USER_STANDARD', 'u_must_introduce']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_LIMITED']],
				['permission.permission_set', ['ROLE_USER_LIMITED', 'u_must_introduce']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_FULL']],
				['permission.permission_unset', ['ROLE_USER_FULL', 'u_must_introduce']],	// Set to no for adminitrators
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_NOPM']],
				['permission.permission_set', ['ROLE_USER_NOPM', 'u_must_introduce']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_NOAVATAR']],
				['permission.permission_set', ['ROLE_USER_NOAVATAR', 'u_must_introduce']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_NEW_MEMBER']],
				['permission.permission_set', ['ROLE_USER_NEW_MEMBER', 'u_must_introduce']],
			]],

			// Global admin role permissions for admin
			['if', [
				['permission.role_exists', ['ROLE_ADMIN_STANDARD']],
				['permission.permission_set', ['ROLE_ADMIN_STANDARD', 'a_introduciator_manage']],
			]],
			['if', [
				['permission.role_exists', ['ROLE_ADMIN_FULL']],
				['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_introduciator_manage']],
			]],
		];
	}
}