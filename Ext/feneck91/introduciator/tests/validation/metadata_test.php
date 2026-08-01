<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\validation;

class metadata_test extends \phpbb_test_case
{
	private const EXPECTED_VERSION = '3.0.0';

	public function test_release_metadata_is_valid_and_synchronised()
	{
		$metadata = $this->metadata();

		$this->assertSame('feneck91/introduciator', $metadata['name']);
		$this->assertSame('phpbb-extension', $metadata['type']);
		$this->assertSame('GPL-2.0-only', $metadata['license']);
		$this->assertSame(self::EXPECTED_VERSION, $metadata['version']);
		$this->assertSame(1, preg_match('/^\d+\.\d+\.\d+$/D', $metadata['version']));
		$this->assertSame(1, preg_match('/^\d{4}-\d{2}-\d{2}$/D', $metadata['time']));

		$info_file = file_get_contents(dirname(__DIR__, 2) . '/acp/introduciator_info.php');
		$this->assertSame(1, preg_match("/'version'\\s*=>\\s*'([^']+)'/", $info_file, $matches));
		$this->assertSame(self::EXPECTED_VERSION, $matches[1]);
	}

	public function test_phpbb_33_branch_is_supported()
	{
		$metadata = $this->metadata();
		$require = $metadata['require']['phpbb/phpbb'];

		$this->assertSame($require, $metadata['extra']['soft-require']['phpbb/phpbb']);
		$this->assertTrue($this->matches_constraint('3.3.0', $require));
		$this->assertTrue($this->matches_constraint('3.3.99', $require));
		$this->assertFalse($this->matches_constraint('4.0.0', $require));
	}

	public function test_php_requirement_accepts_phpbb_33_minimum()
	{
		$this->assertTrue($this->matches_constraint('7.2.0', $this->metadata()['require']['php']));
	}

	private function metadata()
	{
		$data = json_decode(file_get_contents(dirname(__DIR__, 2) . '/composer.json'), true);
		$this->assertIsArray($data, 'composer.json must contain valid JSON.');
		return $data;
	}

	private function matches_constraint($version, $constraint)
	{
		$constraint = preg_replace('/@[a-z]+$/i', '', $constraint);
		foreach (explode(',', $constraint) as $part)
		{
			if (!preg_match('/^\s*(>=|<=|>|<|=)?\s*(\d+(?:\.\d+){0,2})\s*$/', $part, $matches))
			{
				$this->fail('Unsupported Composer constraint in validation test: ' . $part);
			}
			if (!version_compare($version, $matches[2], $matches[1] ?: '='))
			{
				return false;
			}
		}
		return true;
	}
}
