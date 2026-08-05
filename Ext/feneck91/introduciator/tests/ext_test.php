<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests;

use feneck91\introduciator\ext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ext_test_user
{
	public $lang = [
		'EXTENSION_ENABLE_SUCCESS' => 'Extension enabled.',
		'INTRODUCIATOR_NOTICE' => 'Configure in %1$s > %2$s > %3$s; disabled until configured.',
		'ACP_CAT_DOT_MODS' => 'Extensions',
		'ACP_INTRODUCIATOR_EXTENSION' => 'Introduciator',
		'INTRODUCIATOR_CONFIGURATION' => 'Configuration',
	];

	public $loaded_language = false;

	public function add_lang_ext($extension, $file)
	{
		$this->loaded_language = [$extension, $file];
	}
}

class ext_test_template
{
	public $vars = [];

	public function assign_var($name, $value)
	{
		$this->vars[$name] = $value;
	}
}

class ext_test extends \phpbb_test_case
{
	public function version_data()
	{
		return [
			['3.2.7', false],
			['3.2.8', true],
			['3.3.0', true],
			['3.3.15', true],
		];
	}

	/**
	 * @dataProvider version_data
	 */
	public function test_is_enableable($phpbb_version, $expected)
	{
		[$extension] = $this->create_extension($phpbb_version);
		$this->assertSame($expected, $extension->is_enableable());
	}

	public function test_first_enable_adds_configuration_notice()
	{
		[$extension, $user, $template] = $this->create_extension('3.3.15');

		$extension->enable_step(false);

		$this->assertSame(
			['feneck91/introduciator', 'info_acp_introduciator'],
			$user->loaded_language
		);
		$this->assertArrayHasKey('L_EXTENSION_ENABLE_SUCCESS', $template->vars);
		$this->assertStringContainsString('disabled until configured', $template->vars['L_EXTENSION_ENABLE_SUCCESS']);
		$this->assertStringContainsString('Extensions > Introduciator > Configuration', $template->vars['L_EXTENSION_ENABLE_SUCCESS']);
	}

	public function test_later_enable_step_does_not_replace_success_message()
	{
		[$extension, $user, $template] = $this->create_extension('3.3.15');

		$extension->enable_step(true);

		$this->assertFalse($user->loaded_language);
		$this->assertSame([], $template->vars);
	}

	private function create_extension($phpbb_version)
	{
		$container = new ContainerBuilder();
		$user = new ext_test_user();
		$template = new ext_test_template();
		$container->set('config', new \phpbb\config\config(['version' => $phpbb_version]));
		$container->set('user', $user);
		$container->set('template', $template);

		$finder = $this->getMockBuilder('\phpbb\finder')
			->disableOriginalConstructor()
			->getMock();
		$finder->method('extension_directory')->willReturn($finder);
		$finder->method('find_from_extension')->willReturn([]);
		$finder->method('get_classes_from_files')->willReturn([]);

		$migrator = $this->getMockBuilder('\phpbb\db\migrator')
			->disableOriginalConstructor()
			->getMock();
		$migrator->method('get_migrations')->willReturn([]);
		$migrator->method('finished')->willReturn(true);

		return [
			new ext($container, $finder, $migrator, 'feneck91/introduciator', 'ext/feneck91/introduciator/'),
			$user,
			$template,
		];
	}
}
