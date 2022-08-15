<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\migrations\v2_0_0;

class v2_0_0_data extends \phpbb\db\migration\migration
{
	/**
	 * Get the migration dependencie.
	 *
	 * @return array Array of depending items.
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320rc2');
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
			['permission.permission_set', ['ROLE_USER_STANDARD', 'u_must_introduce', 'role']],
			['permission.permission_set', ['ROLE_USER_LIMITED', 'u_must_introduce', 'role']],
			['permission.permission_unset', ['ROLE_USER_FULL', 'u_must_introduce', 'role']],	// Set to no for adminitrators
			['permission.permission_set', ['ROLE_USER_NOPM', 'u_must_introduce', 'role']],
			['permission.permission_set', ['ROLE_USER_NOAVATAR', 'u_must_introduce', 'role']],
			['permission.permission_set', ['ROLE_USER_NEW_MEMBER', 'u_must_introduce', 'role']],

			// Global admin role permissions for admin
			['permission.permission_set', ['ROLE_ADMIN_STANDARD', 'a_introduciator_manage', 'role']],
			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_introduciator_manage', 'role']],

			//===============================================================================
			// Add the module in ACP under the customise tab

			// Add a new category named ACP_INTRODUCIATOR_EXTENSION to ACP_CAT_DOT_MODS (under tab 'extensions' in ACP)
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INTRODUCIATOR_EXTENSION',
				[
					'module_basename'	=> '\feneck91\introduciator\acp\introduciator_module',
					'modes'	  			=> [
						//---------------------------------------------------------------------
						// Creation of ACP sub caterories under Introduciator extension into Extensions tab
						'general',
						'configuration',
						'explanation',
						'statistics',
						// Creation of ACP sub caterories under Introduciator extension into Extensions tab
						//---------------------------------------------------------------------
					],
				],
			]],

			// Add the module in ACP under the customise tab
			//===============================================================================
		];
	}
}