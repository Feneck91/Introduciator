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

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound

/**
 * The claim is taken from inside the posting path, which no test can drive without a booted
 * board, so expose it directly.
 */
class claiming_helper extends introduciator_helper
{
	public function claim($user_id)
	{
		return $this->claim_introduction_slot($user_id);
	}
}

/**
 * Guards the protection against a member ending up with more than one introduction after a double
 * click, a slow-network resubmit, two open tabs, or back-button plus resubmit. It is an atomic
 * create-or-fail on the filesystem, so it is testable without any of that.
 */
class claim_slot_test extends helper_test_base
{
	/** @var string */
	private $root;

	protected function setUp(): void
	{
		parent::setUp();

		$this->root = rtrim(strtr(sys_get_temp_dir(), DIRECTORY_SEPARATOR, '/'), '/') . '/introduciator_claim_' . uniqid('', true);
		mkdir($this->root, 0777, true);
	}

	protected function tearDown(): void
	{
		$this->remove_tree($this->root);

		parent::tearDown();
	}

	public function test_a_first_submission_takes_the_slot()
	{
		$helper = $this->claiming();

		$this->assertTrue($helper->claim(11));
		$this->assertFileExists($helper->get_claim_dir() . '/claim_11');
	}

	public function test_a_concurrent_submission_by_the_same_user_is_refused()
	{
		$first = $this->claiming();
		$second = $this->claiming();

		$this->assertTrue($first->claim(11));
		$this->assertFalse($second->claim(11), 'A second in-flight submission must not also be allowed through.');
	}

	public function test_two_different_users_do_not_block_each_other()
	{
		$first = $this->claiming();
		$second = $this->claiming();

		$this->assertTrue($first->claim(11));
		$this->assertTrue($second->claim(12));
	}

	public function test_releasing_lets_the_user_introduce_again()
	{
		$helper = $this->claiming();

		$this->assertTrue($helper->claim(11));
		$helper->release_introduction_slot();

		$this->assertTrue($this->claiming()->claim(11));
	}

	public function test_releasing_without_a_claim_is_harmless()
	{
		$helper = $this->claiming();

		$helper->release_introduction_slot();
		$helper->release_introduction_slot();

		$this->assertTrue($helper->claim(11));
	}

	/**
	 * A request that dies before releasing would otherwise lock the user out of introducing
	 * themselves for good.
	 */
	public function test_an_abandoned_claim_expires()
	{
		$helper = $this->claiming();
		$this->assertTrue($helper->claim(11));

		$claim_file = $helper->get_claim_dir() . '/claim_11';
		touch($claim_file, time() - introduciator_helper::CLAIM_TIMEOUT - 1);

		$this->assertTrue($this->claiming()->claim(11), 'A claim older than the timeout must be reclaimable.');
	}

	public function test_a_fresh_claim_does_not_expire()
	{
		$helper = $this->claiming();
		$this->assertTrue($helper->claim(11));

		touch($helper->get_claim_dir() . '/claim_11', time() - introduciator_helper::CLAIM_TIMEOUT + 5);

		$this->assertFalse($this->claiming()->claim(11));
	}

	public function test_writable_storage_is_reported_as_such()
	{
		$this->assertTrue($this->claiming()->is_claim_storage_writable());
	}

	/**
	 * The protection fails open on purpose: an unusable store must not stop the whole board from
	 * introducing itself. The admin is warned about it on the ACP General page instead.
	 */
	public function test_unusable_storage_fails_open()
	{
		$blocking_file = $this->root . '/not_a_directory';
		file_put_contents($blocking_file, 'x');

		$helper = $this->claiming($blocking_file);

		$this->assertFalse($helper->is_claim_storage_writable());
		$this->assertTrue($helper->claim(11), 'A board with unusable claim storage must still accept introductions.');
	}

	private function claiming($root = null)
	{
		return $this->create_helper([], $root === null ? $this->root : $root, claiming_helper::class);
	}

	private function remove_tree($path)
	{
		if (!is_dir($path))
		{
			@unlink($path);

			return;
		}

		foreach (array_diff(scandir($path), ['.', '..']) as $entry)
		{
			$this->remove_tree($path . '/' . $entry);
		}

		@rmdir($path);
	}
}
