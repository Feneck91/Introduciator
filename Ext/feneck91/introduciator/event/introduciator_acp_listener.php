<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class introduciator_acp_listener implements EventSubscriberInterface
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	/**
	 * Called by framework to get event list.
	 *
	 * Return an array that contains event list with associated callback for each event.
	 *
	 * @return array
	 * @static
	 * @access public
	 */

	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'		=> 'add_permission',
		);
	}

	/**
	 * Manage Introduciator permissions
	 *
	 * @param array $event
	 * @access public
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];

		$permissions += array(
			// Administators
			'a_shout_manage'		=> array('lang' => 'ACL_A_INTRODUCIATOR_MANAGE', 	'cat' => 'misc'),

			// Users
			'u_shout_bbcode'		=> array('lang' => 'ACL_U_MUST_INTRODUCE',			'cat' => 'post'),
		);

		$event['permissions'] = $permissions;
	}
}
