<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\validation;

class language_catalog_test extends \phpbb_test_case
{
	public function test_translations_contain_all_english_keys()
	{
		$language_root = dirname(__DIR__, 2) . '/language';
		$english_files = glob($language_root . '/en/*.php');

		foreach (glob($language_root . '/*', GLOB_ONLYDIR) as $language_dir)
		{
			if (basename($language_dir) === 'en')
			{
				continue;
			}

			foreach ($english_files as $english_file)
			{
				$translation_file = $language_dir . '/' . basename($english_file);
				// phpBB falls back to English when a translated catalogue file is
				// absent. If a translation does provide the file, it must be complete.
				if (!is_file($translation_file))
				{
					continue;
				}

				$missing = array_diff_key($this->load_language($english_file), $this->load_language($translation_file));
				$this->assertSame([], array_keys($missing), $translation_file . ' is missing language keys.');
			}
		}
	}

	public function test_extension_template_language_keys_exist_in_english()
	{
		$root = dirname(__DIR__, 2);
		$catalog = [];
		foreach (glob($root . '/language/en/*.php') as $file)
		{
			$catalog += $this->load_language($file);
		}

		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root));
		foreach ($iterator as $file)
		{
			if (!$file->isFile() || !in_array($file->getExtension(), ['html', 'php'], true))
			{
				continue;
			}
			preg_match_all('/(?:lang|lang_js)\(\s*[\'\"](INTRODUCIATOR_[A-Z0-9_]+)[\'\"]/', file_get_contents($file->getPathname()), $matches);
			foreach (array_unique($matches[1]) as $key)
			{
				$this->assertArrayHasKey($key, $catalog, $file->getPathname() . ' uses an undefined language key.');
			}
		}
	}

	private function load_language($file)
	{
		$lang = [];
		include $file;
		return $lang;
	}
}
