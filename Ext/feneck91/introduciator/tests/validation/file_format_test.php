<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\validation;

class file_format_test extends \phpbb_test_case
{
	/**
	 * phpBB's coding guidelines require UTF-8 without BOM and UNIX line endings for every source
	 * file, not only the PHP ones: templates, YAML and JSON are just as much part of the package.
	 */
	private const TEXT_EXTENSIONS = ['php', 'html', 'yml', 'json', 'xml', 'css', 'js', 'md', 'txt'];

	public function test_source_files_follow_phpbb_encoding_rules()
	{
		$checked = 0;

		foreach ($this->text_files() as $path)
		{
			$content = file_get_contents($path);
			$checked++;

			$this->assertStringStartsNotWith("\xEF\xBB\xBF", $content, $path . ' contains a UTF-8 BOM.');
			$this->assertStringNotContainsString("\r\n", $content, $path . ' uses Windows line endings.');
			$this->assertSame("\n", substr($content, -1), $path . ' must end with a newline.');
		}

		$this->assertGreaterThan(0, $checked, 'No source file was checked, the iterator is broken.');
	}

	public function test_php_files_are_valid_utf8()
	{
		foreach ($this->text_files() as $path)
		{
			$this->assertTrue(
				(bool) preg_match('//u', file_get_contents($path)),
				$path . ' is not valid UTF-8.'
			);
		}
	}

	/**
	 * @return \Generator
	 */
	private function text_files()
	{
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(dirname(__DIR__, 2), \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			if ($file->isFile() && in_array(strtolower($file->getExtension()), self::TEXT_EXTENSIONS, true))
			{
				yield $file->getPathname();
			}
		}
	}
}
