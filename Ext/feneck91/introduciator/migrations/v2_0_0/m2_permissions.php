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