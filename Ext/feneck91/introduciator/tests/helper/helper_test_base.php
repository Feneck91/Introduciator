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
 * Builds an introduciator_helper wired to doubles, so the pure decision logic can be exercised
 * without a database or a booted phpBB.
 */
abstract class helper_test_base extends \phpbb_test_case
{
	/**
	 * The configuration introduciator_getparams() reads. Defaults describe a freshly installed,
	 * enabled board in forum mode; tests override only the keys they care about.
	 *
	 * @return array
	 */
	protected function default_config()
	{
		return [
			'introduciator_allow'						=> 1,
			'introduciator_mode'						=> introduciator_helper::MODE_FORUM,
			'introduciator_fk_forum_id'					=> 7,
			'introduciator_fk_topic_id'					=> 0,
			'introduciator_is_introduction_mandatory'	=> 1,
			'introduciator_is_check_delete_first_post'	=> 1,
			'introduciator_is_check_move_duplicate'		=> 1,
			'introduciator_is_explanation_enabled'		=> 0,
			'introduciator_is_use_permissions'			=> 1,
			'introduciator_is_include_groups'			=> 1,
			'introduciator_ignored_users'				=> '',
			'introduciator_is_explanation_display_rules'=> 1,
			'introduciator_posting_approval_level'		=> introduciator_helper::APPROVAL_LEVEL_NO_APPROVAL,
		];
	}

	/**
	 * @param array  $config    Overrides merged over default_config()
	 * @param string $root_path phpBB root the helper should resolve paths against
	 * @param string $class     Helper class to build, so subclasses can expose protected members
	 * @param mixed  $db        Database double, or null for one that answers nothing
	 *
	 * @return introduciator_helper
	 */
	protected function create_helper(array $config = [], $root_path = '', $class = introduciator_helper::class, $db = null)
	{
		return new $class(
			'phpbb_introduciator_groups',
			'phpbb_introduciator_explanation',
			$root_path,
			'php',
			$this->mock(\phpbb\user::class),
			$db === null ? $this->mock(\phpbb\db\driver\factory::class) : $db,
			new \phpbb\config\config(array_merge($this->default_config(), $config)),
			$this->mock(\phpbb\auth\auth::class),
			$this->mock(\phpbb\controller\helper::class),
			$this->mock(\phpbb\language\language::class)
		);
	}

	private function mock($class)
	{
		return $this->getMockBuilder($class)->disableOriginalConstructor()->getMock();
	}
}
