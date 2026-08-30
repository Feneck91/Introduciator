<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\helper;

use feneck91\introduciator\helper\introduciator_helper;

/**
 * The explanation texts cannot store %forum_url% / %forum_post% literally, because phpBB's BBCode
 * parser rejects a [url] tag whose content is not a valid URL. They are swapped for dummy URLs on
 * save and swapped back on display and on edit. The two halves used to disagree about the dummy
 * URLs, so the placeholders were lost the moment the admin reopened the ACP page.
 */
class placeholder_test extends helper_test_base
{
	public function test_a_saved_placeholder_survives_being_reopened_for_editing()
	{
		$typed = 'See [url=%forum_url%]our board[/url] and then [url=%forum_post%]post[/url].';

		$stored = $this->as_stored($typed);
		$this->assertStringNotContainsString('%forum_url%', $stored, 'The forward swap did not run.');

		$this->assertSame($typed, $this->as_edited($stored));
	}

	/**
	 * Boards on the legacy BBCode storage get the dummy URL back entity-escaped, because
	 * bbcode_specialchars() escapes ':' and '.' inside [url] tags.
	 */
	public function test_the_entity_escaped_form_is_restored_too()
	{
		$stored = 'Go to http&#58;//aghxkfps&#46;tld now, or post at http&#58;//dqsdfzef&#46;tld.';

		$this->assertSame('Go to %forum_url% now, or post at %forum_post%.', $this->as_edited($stored));
	}

	public function test_text_without_placeholders_is_left_alone()
	{
		$text = 'Nothing to substitute here, not even https://example.com.';

		$this->assertSame($text, $this->as_edited($text));
	}

	/**
	 * Guards against the two halves drifting apart again: nothing may hardcode the dummy hosts
	 * except the constants that define them.
	 */
	public function test_the_dummy_urls_are_only_spelled_out_once()
	{
		$root = dirname(__DIR__, 2);
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			if (!$file->isFile() || $file->getExtension() !== 'php' || strpos($file->getPathname(), 'tests') !== false)
			{
				continue;
			}

			$occurrences = preg_match_all('/aghxkfps|dqsdfzef/', file_get_contents($file->getPathname()));
			$expected = basename($file->getPathname()) === 'introduciator_helper.php' ? 2 : 0;

			$this->assertSame(
				$expected,
				$occurrences,
				$file->getPathname() . ' spells out a dummy placeholder URL instead of using the helper constants.'
			);
		}
	}

	/**
	 * What the ACP explanation controller writes to the database.
	 */
	private function as_stored($text)
	{
		return str_replace(
			['%forum_url%', '%forum_post%'],
			[introduciator_helper::PLACEHOLDER_URL_FORUM, introduciator_helper::PLACEHOLDER_URL_POST],
			$text
		);
	}

	/**
	 * What the helper shows the admin when the texts are loaded back for editing.
	 */
	private function as_edited($text)
	{
		$helper = $this->create_helper();
		$fields = [&$text];
		$helper->replace_all_by($fields, introduciator_helper::get_placeholder_restore_map());

		return $text;
	}
}
