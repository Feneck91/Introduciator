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
}