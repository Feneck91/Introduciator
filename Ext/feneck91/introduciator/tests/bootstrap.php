<?php
/**
 *
 * Introduciator tests
 *
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

// phpcs:ignoreFile -- Test bootstrap intentionally registers loaders, stubs and constants.

error_reporting(E_ALL & ~E_DEPRECATED);

$project_root = dirname(__DIR__, 4);
$phpbb_root = getenv('PHPBB_ROOT_PATH');
$phpbb_root = $phpbb_root ? rtrim($phpbb_root, '/\\') : $project_root . '/_forum';

if (is_file($project_root . '/vendor/autoload.php'))
{
	require_once $project_root . '/vendor/autoload.php';
}

if (!is_file($phpbb_root . '/vendor/autoload.php') || !is_file($phpbb_root . '/phpbb/class_loader.php'))
{
	throw new \RuntimeException('phpBB dependencies were not found. Set PHPBB_ROOT_PATH to a prepared phpBB checkout.');
}

require_once $phpbb_root . '/vendor/autoload.php';
require_once $phpbb_root . '/phpbb/class_loader.php';

$phpbb_class_loader = new \phpbb\class_loader('phpbb\\', $phpbb_root . '/phpbb/');
$phpbb_class_loader->register();

$extension_class_loader = new \phpbb\class_loader(
	'feneck91\\introduciator\\',
	dirname(__DIR__) . '/'
);
$extension_class_loader->register();

if (!defined('IN_PHPBB'))
{
	define('IN_PHPBB', true);
}

if (!defined('PHPBB_TEST_ROOT_PATH'))
{
	// Where the tests can find the phpBB checkout they are validating against.
	define('PHPBB_TEST_ROOT_PATH', $phpbb_root);
}

// The helper leans on phpBB's UTF-8 helpers, which live in a plain function file rather than
// behind the autoloader, so tests exercising it have to pull them in explicitly.
if (!function_exists('utf8_strtolower'))
{
	require_once $phpbb_root . '/includes/utf/utf_tools.php';
}

// phpBB's constants (POST_NORMAL, ITEM_*, ANONYMOUS) and its table-name constants live in a
// plain file that common.php loads with the board's table prefix in scope. Unit tests never
// reach a real database, so a fixed prefix is enough to make the SQL strings well formed.
if (!defined('TOPICS_TABLE'))
{
	$table_prefix = 'phpbb_';
	require_once $phpbb_root . '/includes/constants.php';
}

if (!class_exists('phpbb_test_case', false))
{
	// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
	abstract class phpbb_test_case extends \PHPUnit\Framework\TestCase
	{
	}
	// phpcs:enable
}

if (!function_exists('phpbb_version_compare'))
{
	function phpbb_version_compare($version1, $version2, $operator = null)
	{
		$version1 = strtolower($version1);
		$version2 = strtolower($version2);

		return $operator === null ?
			version_compare($version1, $version2) :
			version_compare($version1, $version2, $operator);
	}
}
