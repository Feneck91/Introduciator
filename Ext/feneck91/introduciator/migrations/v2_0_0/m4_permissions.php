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

class m4_permissions extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencies.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return array(
			'\feneck91\introduciator\migrations\v2_0_0\m1_data',
			'\feneck91\introduciator\migrations\v2_0_0\m2_acp_module',
			'\feneck91\introduciator\migrations\v2_0_0\m3_schema',
		);
	}

	/**
	 * Update data of the database.
	 *
	 * @return array Array of elements to update.
	 * @access public
	 */
	public function update_data()
	{
		return array(
			// Add admin permissions
			array('permission.add', array('a_introduciator_manage', true)),

			// Add user permissions
			array('permission.add', array('u_must_introduce', true)),

			// Set permissions users
			array('permission.permission_set', array('ADMINISTRATORS', 'u_must_introduce', 'group', false)), // Set to never for administrators
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'u_must_introduce', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_must_introduce', 'group')),
			array('permission.permission_set', array('NEWLY_REGISTERED', 'u_must_introduce', 'group')),

			// Set permissions administration
			array('permission.permission_set', array('ADMINISTRATORS', 'a_introduciator_manage', 'group')),

			// Global user role permissions for user mask
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_must_introduce', 'role')),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_must_introduce', 'role')),
			array('permission.permission_unset', array('ROLE_USER_FULL', 'u_must_introduce', 'role')),	// Set to no for administrators
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_must_introduce', 'role')),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_must_introduce', 'role')),
			array('permission.permission_set', array('ROLE_USER_NEW_MEMBER', 'u_must_introduce', 'role')),

			// Global admin role permissions for admin
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_introduciator_manage', 'role')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_introduciator_manage', 'role')),
		);
	}
}