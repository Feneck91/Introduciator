<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\helper;

class ignored_users_test extends helper_test_base
{
	public static function list_data()
	{
		return [
			'empty list'					=> ['', []],
			'single name'					=> ['Feneck91', ['feneck91']],
			'unix separated'				=> ["Alice\nBob", ['alice', 'bob']],
			'windows separated'				=> ["Alice\r\nBob", ['alice', 'bob']],
			'old macintosh separated'		=> ["Alice\rBob", ['alice', 'bob']],
			'trailing newline'				=> ["Alice\n", ['alice']],
			'blank lines in the middle'		=> ["Alice\n\n\nBob", ['alice', 'bob']],
			'surrounding whitespace'		=> ["  Alice  \n\tBob\t", ['alice', 'bob']],
			'accented names are lowercased'	=> ["Stéphane\nJOÃO", ['stéphane', 'joão']],
		];
	}

	/**
	 * @dataProvider list_data
	 */
	public function test_list_is_parsed($configured, $expected)
	{
		$helper = $this->create_helper(['introduciator_ignored_users' => $configured]);

		$this->assertSame($expected, $helper->get_ignored_users_list());
	}

	/**
	 * A CRLF-saved list used to leave a trailing \r on every entry but the last, so those names
	 * were configured as ignored yet never actually matched.
	 */
	public function test_windows_saved_entry_matches_the_username()
	{
		$helper = $this->create_helper(['introduciator_ignored_users' => "Alice\r\nBob"]);

		$this->assertContains('alice', $helper->get_ignored_users_list());
	}

	/**
	 * A trailing newline must not turn into an empty entry: an empty username would otherwise
	 * match phpBB's anonymous user and quietly exempt guests.
	 */
	public function test_empty_entries_are_dropped()
	{
		$helper = $this->create_helper(['introduciator_ignored_users' => "Alice\n\n"]);

		$this->assertNotContains('', $helper->get_ignored_users_list());
	}
}
