<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\listener;

use feneck91\introduciator\event\introduciator_acp_listener;
use feneck91\introduciator\event\introduciator_listener;

/**
 * The extension hangs entirely off phpBB core events. If one is renamed or dropped upstream, or
 * a callback is renamed here, nothing fails loudly: the listener simply stops running and the
 * board silently loses the behaviour. These tests turn that into a test failure.
 */
class subscribed_events_test extends \phpbb_test_case
{
	public static function listener_data()
	{
		return [
			'main listener'	=> [introduciator_listener::class],
			'acp listener'	=> [introduciator_acp_listener::class],
		];
	}

	/**
	 * @dataProvider listener_data
	 */
	public function test_every_callback_exists($listener_class)
	{
		$subscribed = $listener_class::getSubscribedEvents();

		$this->assertNotEmpty($subscribed, $listener_class . ' subscribes to nothing.');

		foreach ($subscribed as $event => $callback)
		{
			$callback = is_array($callback) ? $callback[0] : $callback;

			$this->assertTrue(
				method_exists($listener_class, $callback),
				$listener_class . ' subscribes ' . $event . ' to a missing method ' . $callback . '().'
			);
		}
	}

	/**
	 * @dataProvider listener_data
	 */
	public function test_every_event_is_dispatched_by_this_phpbb($listener_class)
	{
		$sources = $this->core_sources();

		foreach (array_keys($listener_class::getSubscribedEvents()) as $event)
		{
			$this->assertTrue(
				$this->is_dispatched($event, $sources),
				$event . ' is not dispatched anywhere in the phpBB checkout under test.'
			);
		}
	}

	private function is_dispatched($event, array $sources)
	{
		$needle = "trigger_event('" . $event . "'";

		foreach ($sources as $source)
		{
			if (strpos(file_get_contents($source), $needle) !== false)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @return array phpBB's own PHP sources, excluding extensions, vendor code and caches.
	 */
	private function core_sources()
	{
		$root = PHPBB_TEST_ROOT_PATH;
		$sources = glob($root . '/*.php');

		foreach (['phpbb', 'includes'] as $directory)
		{
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($root . '/' . $directory, \FilesystemIterator::SKIP_DOTS)
			);

			foreach ($iterator as $file)
			{
				if ($file->isFile() && $file->getExtension() === 'php')
				{
					$sources[] = $file->getPathname();
				}
			}
		}

		return $sources;
	}
}
