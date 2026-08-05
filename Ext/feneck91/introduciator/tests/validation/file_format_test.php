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
	public function test_php_files_follow_phpbb_encoding_rules()
	{
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(dirname(__DIR__, 2), \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file)
		{
			if (!$file->isFile() || $file->getExtension() !== 'php')
			{
				continue;
			}

			$content = file_get_contents($file->getPathname());
			$this->assertStringStartsNotWith("\xEF\xBB\xBF", $content, $file->getPathname() . ' contains a UTF-8 BOM.');
			$this->assertStringNotContainsString("\r\n", $content, $file->getPathname() . ' uses Windows line endings.');
			$this->assertSame("\n", substr($content, -1), $file->getPathname() . ' must end with a newline.');
		}
	}
}
