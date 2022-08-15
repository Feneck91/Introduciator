<?php

/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class introduciator_acp_listener implements EventSubscriberInterface
{
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
		return [
			'core.permissions'		=> 'add_permissions',
		];
	}

	/**
	 * Manage Introduciator permissions
	 *
	 * @param \phpbb\event\data $event The event object
	 *
	 * @return void
	 * @access public
	 */
	public function add_permissions($event)
	{
		$event->update_subarray('permissions', 'a_introduciator_manage', ['lang' => 'ACL_A_INTRODUCIATOR_MANAGE', 'cat' => 'misc']);
		$event->update_subarray('permissions', 'u_must_introduce', ['lang' => 'ACL_U_MUST_INTRODUCE', 'cat' => 'post']);
	}
}