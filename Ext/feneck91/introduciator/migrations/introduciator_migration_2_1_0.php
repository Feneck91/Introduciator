<?php

/**
*
* @package phpBB Extension - Introduciator Extension
* @author Feneck91 (Stéphane Château) feneck91@free.fr
* @copyright (c) 2013 @copyright (c) 2014 Feneck91
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace feneck91\introduciator\migrations;

class introduciator_migration_2_1_0 extends \phpbb\db\migration\migration
{
	/**
	 * Add the table schema to the database.
	 *
	 * Only add the introduciator group table is added
	 *
	 * @return array Array of table schema to create / update
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			// Add Groups list table
			'add_tables' => array(
				$this->table_prefix . 'introduciator_groups' => array(
					'COLUMNS' => array(
						'fk_group'			=> array('UINT', NULL),
					),
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
			'drop_tables' => array($this->table_prefix . 'introduciator_groups',
			),
		);
	}

	/**
	 * Update data of the databse.
	 *
	 * @return Array of elements to update.
	 * @access public
	 */
	public function update_data()
	{
		return array(
			// Introduciator Settings
			array('config.add', array('introduciator_explanation_message_title_uid',					'')),
			array('config.add', array('introduciator_explanation_message_title_bitfield',				'')),
			array('config.add', array('introduciator_explanation_message_title_bbcode_options',			'')),
			array('config.add', array('introduciator_explanation_message_text_uid',						'')),
			array('config.add', array('introduciator_explanation_message_text_bitfield',				'')),
			array('config.add', array('introduciator_explanation_message_text_bbcode_options',			'')),
			array('config.add', array('introduciator_explanation_message_rules_title_uid',				'')),
			array('config.add', array('introduciator_explanation_message_rules_title_bitfield',			'')),
			array('config.add', array('introduciator_explanation_message_rules_title_bbcode_options',	'')),
			array('config.add', array('introduciator_explanation_message_rules_text_uid',				'')),
			array('config.add', array('introduciator_explanation_message_rules_text_bitfield',			'')),
			array('config.add', array('introduciator_explanation_message_rules_text_bbcode_options',	'')),
			array('config.add', array('introduciator_posting_approval_level',							0)),
			array('config.add', array('introduciator_allow', 											'0')),
			array('config.add', array('introduciator_fk_forum_id', 										0)),
			array('config.add', array('introduciator_is_introduction_mandatory', 						true)),
			array('config.add', array('introduciator_is_check_delete_first_post', 						true)),
			array('config.add', array('introduciator_is_explanation_enabled', 							false)),
			array('config.add', array('introduciator_is_use_permissions', 								true)),
			array('config.add', array('introduciator_is_include_groups', 								true)),
			array('config.add', array('introduciator_ignored_users', 									'')),
			array('config.add', array('introduciator_explanation_message_title', 						'%explanation_title%')),
			array('config.add', array('introduciator_explanation_message_text', 						'%explanation_text%')),
			array('config.add', array('introduciator_is_explanation_display_rules', 					true)),
			array('config.add', array('introduciator_explanation_message_rules_title', 					'%rules_title%')),
			array('config.add', array('introduciator_explanation_message_rules_text', 					'%rules_text%')),

			// Misc Settings
			array('config.add', array('introduciator_install_date', 									time())),
			array('config.add', array('introduciator_extension_version', 								'2.1.0')), // Current extension's version 
			
			// Permissions Add
			array('permission.add', array('a_introduciator_manage',										true)),
			array('permission.add', array('u_must_introduce', 											true)),

			// Global user role permissions for user mask : Yes to All
			array('permission.permission_set', array('ROLE_USER_STANDARD', 								'u_must_introduce')),
			array('permission.permission_set', array('ROLE_USER_LIMITED', 								'u_must_introduce')),
			array('permission.permission_set', array('ROLE_USER_NEW_MEMBER', 							'u_must_introduce')),

			// Global admin role permissions for admin : Yes to All
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 							'a_introduciator_manage')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 								'a_introduciator_manage')),

			//===============================================================================
			// Add the module in ACP under the customise tab

			// Add a new category named ACP_INTRODUCIATOR_EXTENSIOB to ACP_CAT_DOT_MODS (under tab 'extensions' in ACP)
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_INTRODUCIATOR_EXTENSION')),

			array('module.add', array(
					'acp',
					'ACP_INTRODUCIATOR_EXTENSION',
					array(
						'module_basename'	=> '\feneck91\introduciator\acp\introduciator_module', 
						'modes'	  			=> array(
							//---------------------------------------------------------------------
							// Creation of ACP sub caterories under Introduciator extension into Extensions tab
							'general',
							'configuration',
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
