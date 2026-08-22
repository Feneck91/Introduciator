<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests;

use feneck91\introduciator\migrations\v2_0_0\m3_schema;
use feneck91\introduciator\migrations\v2_1_0\m1_topic_mode;
use feneck91\introduciator\migrations\v2_1_0\m3_topic_title_template;

class migration_test extends \phpbb_test_case
{
	public function test_topic_mode_depends_on_complete_legacy_install()
	{
		$this->assertSame(
			['\feneck91\introduciator\migrations\v2_0_0\m4_permissions'],
			m1_topic_mode::depends_on()
		);
	}

	public function test_legacy_schema_requires_both_tables()
	{
		$db_tools = $this->create_db_tools_mock();
		$db_tools->expects($this->exactly(2))
			->method('sql_table_exists')
			->willReturnOnConsecutiveCalls(true, false);

		$migration = $this->create_migration(m3_schema::class, $db_tools);

		$this->assertFalse($migration->effectively_installed());
	}

	public function test_missing_explanation_table_is_recreated_with_current_schema()
	{
		$db_tools = $this->create_db_tools_mock();
		$db_tools->method('sql_table_exists')->willReturn(false);

		$migration = $this->create_migration(m3_topic_title_template::class, $db_tools);
		$schema = $migration->update_schema();
		$table = 'phpbb_introduciator_explanation';

		$this->assertArrayHasKey($table, $schema['add_tables']);
		$this->assertArrayHasKey('topic_title_template', $schema['add_tables'][$table]['COLUMNS']);
	}

	public function test_existing_explanation_table_only_gets_new_column()
	{
		$db_tools = $this->create_db_tools_mock();
		$db_tools->method('sql_table_exists')->willReturn(true);

		$migration = $this->create_migration(m3_topic_title_template::class, $db_tools);
		$schema = $migration->update_schema();

		$this->assertArrayHasKey(
			'topic_title_template',
			$schema['add_columns']['phpbb_introduciator_explanation']
		);
	}

	private function create_db_tools_mock()
	{
		return $this->getMockBuilder('\phpbb\db\tools\tools_interface')
			->getMock();
	}

	private function create_migration($class, $db_tools)
	{
		$config = new \phpbb\config\config([]);
		$db = $this->getMockBuilder('\phpbb\db\driver\driver_interface')->getMock();

		return new $class($config, $db, $db_tools, '', 'php', 'phpbb_');
	}
}
