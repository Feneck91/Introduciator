<?php

namespace feneck91\introduciator;

/**
 * Class used to check the phpBB version before beeing able to install it.
 *
 * In fact, one event does not exists before the 3.2.8-RC1 version. Should have a look to https://tracker.phpbb.com/browse/PHPBB3-15946.
 * The 3.2.8-RC1 is a release candidate, so the first version accepted for this extension is 3.2.8.
 */

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return phpbb_version_compare($config['version'], '3.2.8', '>=');
	}

	/**
	 * Point the admin at the configuration page on the very first enable
	 * step, so the "extension enabled successfully" screen doubles as the
	 * next-steps notice instead of leaving them to find it on their own.
	 *
	 * @param mixed $old_state State returned by the previous call of this method.
	 * @return mixed Same as the parent implementation.
	 */
	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$user = $this->container->get('user');
			$user->add_lang_ext('feneck91/introduciator', 'info_acp_introduciator');

			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $user->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($user->lang['INTRODUCIATOR_NOTICE']) ?
					sprintf($user->lang['INTRODUCIATOR_NOTICE'],
									$user->lang['ACP_CAT_DOT_MODS'],
									$user->lang['ACP_INTRODUCIATOR_EXTENSION'],
									$user->lang['INTRODUCIATOR_CONFIGURATION']) : ''));
		}

		return parent::enable_step($old_state);
	}
}
