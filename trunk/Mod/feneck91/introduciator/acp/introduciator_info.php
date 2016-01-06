<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2013 @copyright (c) 2014 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\acp;

class introduciator_info
{
	function module()
	{
		return array(
			'filename'	=> '\feneck91\introduciator\acp\introduciator_module',
			'title'		=> 'ACP_INTRODUCIATOR_MOD',
			'version'	=> "2.1.0",
			'modes'		=> array(
				'general'	=> array(
					'title' => 'INTRODUCIATOR_GENERAL',
					'auth' => 'ext_feneck91/introduciator && acl_a_board', 
					'cat' => array('ACP_INTRODUCIATOR_MOD'),
				),
				'configuration'	=> array(
					'title' => 'INTRODUCIATOR_CONFIGURATION',
					'auth' => 'ext_feneck91/introduciator && acl_a_introduciator_manage', // acl_a_introduciator_manage
					'cat' => array('ACP_INTRODUCIATOR_MOD'),
				),
			),
		);
	}
}
