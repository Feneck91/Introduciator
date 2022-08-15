<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
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
		return array('\phpbb\db\migration\data\v320\v320rc2');
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
		return array(
			// Introduciator Settings
			array('config.add', array('introduciator_posting_approval_level', 0)),
			array('config.add', array('introduciator_allow', '0')),
			array('config.add', array('introduciator_fk_forum_id', 0)),
			array('config.add', array('introduciator_is_introduction_mandatory', true)),
			array('config.add', array('introduciator_is_check_delete_first_post', true)),
			array('config.add', array('introduciator_is_explanation_enabled', false)),
			array('config.add', array('introduciator_is_use_permissions', true)),
			array('config.add', array('introduciator_is_include_groups', true)),
			array('config.add', array('introduciator_ignored_users', '')),
			array('config.add', array('introduciator_is_explanation_display_rules', true)),

			// Misc Settings
			array('config.add', array('introduciator_install_date', time())),

			// Add admin permissions
			array('permission.add', array('a_introduciator_manage', true)),

			// Add user permissions
			array('permission.add', array('u_must_introduce', true)),

			// Set permissions users
			array('permission.permission_set', array('ADMINISTRATORS', 'u_must_introduce', 'group', false)), // Set to never for adminitrators
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'u_must_introduce', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_must_introduce', 'group')),
			array('permission.permission_set', array('NEWLY_REGISTERED', 'u_must_introduce', 'group')),

			// Set permissions administration
			array('permission.permission_set', array('ADMINISTRATORS', 'a_introduciator_manage', 'group')),

			// Global user role permissions for user mask
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_must_introduce', 'role')),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 'u_must_introduce', 'role')),
			array('permission.permission_unset', array('ROLE_USER_FULL', 'u_must_introduce', 'role')),	// Set to no for adminitrators
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_must_introduce', 'role')),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_must_introduce', 'role')),
			array('permission.permission_set', array('ROLE_USER_NEW_MEMBER', 'u_must_introduce', 'role')),

			// Global admin role permissions for admin
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_introduciator_manage', 'role')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_introduciator_manage', 'role')),

			//===============================================================================
			// Add the module in ACP under the customise tab

			// Add a new category named ACP_INTRODUCIATOR_EXTENSION to ACP_CAT_DOT_MODS (under tab 'extensions' in ACP)
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INTRODUCIATOR_EXTENSION',
				array(
					'module_basename'	=> '\feneck91\introduciator\acp\introduciator_module',
					'modes'	  			=> array(
						//---------------------------------------------------------------------
						// Creation of ACP sub caterories under Introduciator extension into Extensions tab
						'general',
						'configuration',
						'explanation',
						'statistics',
						// Creation of ACP sub caterories under Introduciator extension into Extensions tab
						//---------------------------------------------------------------------
					),
				),
			)),

			// Add the module in ACP under the customise tab
			//===============================================================================
		);
	}
}