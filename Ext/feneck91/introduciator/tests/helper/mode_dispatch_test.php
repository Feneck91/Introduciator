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
 * Exposes the introduction lookup so the mode dispatch can be tested without a database: what
 * matters here is which of the two lookups runs, not what either of them returns.
 */
class recording_helper extends introduciator_helper
{
	public $forum_lookup = null;
	public $topic_lookup = null;

	protected function is_user_post_into_forum($forum_id, $user_id, &$topic_id, &$first_post_id, &$topic_approved)
	{
		$this->forum_lookup = ['forum_id' => (int) $forum_id, 'user_id' => (int) $user_id];
		$topic_id = 100;
		$first_post_id = 200;
		$topic_approved = true;

		return true;
	}

	protected function is_user_post_into_topic($topic_id_in, $user_id, &$post_id, &$post_approved)
	{
		$this->topic_lookup = ['topic_id' => (int) $topic_id_in, 'user_id' => (int) $user_id];
		$post_id = 300;
		$post_approved = false;

		return true;
	}
}

/**
 * Topic mode (introduce by posting into one shared topic) is the 3.1.0 feature. Every "is this
 * the introduction?" decision has to answer differently depending on the configured mode.
 */
class mode_dispatch_test extends helper_test_base
{
	public function test_forum_mode_scope_is_the_configured_forum()
	{
		$helper = $this->create_helper();

		$this->assertTrue($helper->is_introduction_scope(7, 0));
		$this->assertTrue($helper->is_introduction_scope(7, 999), 'The topic is irrelevant in forum mode.');
		$this->assertFalse($helper->is_introduction_scope(8, 0));
	}

	public function test_topic_mode_scope_is_the_configured_topic()
	{
		$helper = $this->create_helper($this->topic_mode());

		$this->assertTrue($helper->is_introduction_scope(0, 42));
		$this->assertTrue($helper->is_introduction_scope(999, 42), 'The forum is irrelevant in topic mode.');
		$this->assertFalse($helper->is_introduction_scope(7, 43));
	}

	public function test_forum_mode_introduces_by_starting_a_topic()
	{
		$helper = $this->create_helper();

		$this->assertTrue($helper->is_introduction_action('post', 7, 0));
		$this->assertFalse($helper->is_introduction_action('reply', 7, 55), 'Replying is never an introduction in forum mode.');
		$this->assertFalse($helper->is_introduction_action('post', 8, 0));
	}

	public function test_topic_mode_introduces_by_replying_in_the_shared_topic()
	{
		$helper = $this->create_helper($this->topic_mode());

		$this->assertTrue($helper->is_introduction_action('reply', 7, 42));
		$this->assertTrue($helper->is_introduction_action('quote', 7, 42));
		$this->assertFalse($helper->is_introduction_action('post', 7, 42), 'Starting a topic is never an introduction in topic mode.');
		$this->assertFalse($helper->is_introduction_action('reply', 7, 43));
	}

	public function test_forum_mode_looks_the_introduction_up_by_forum()
	{
		$helper = $this->create_helper([], '', recording_helper::class);

		$topic_id = $post_id = 0;
		$approved = false;
		$helper->has_user_introduced(11, $topic_id, $post_id, $approved);

		$this->assertSame(['forum_id' => 7, 'user_id' => 11], $helper->forum_lookup);
		$this->assertNull($helper->topic_lookup);
		$this->assertSame(100, $topic_id);
		$this->assertSame(200, $post_id);
		$this->assertTrue($approved);
	}

	public function test_topic_mode_looks_the_introduction_up_by_topic()
	{
		$helper = $this->create_helper($this->topic_mode(), '', recording_helper::class);

		$topic_id = $post_id = 0;
		$approved = true;
		$helper->has_user_introduced(11, $topic_id, $post_id, $approved);

		$this->assertSame(['topic_id' => 42, 'user_id' => 11], $helper->topic_lookup);
		$this->assertNull($helper->forum_lookup);
		$this->assertSame(42, $topic_id, 'The shared topic is reported back to the caller.');
		$this->assertSame(300, $post_id);
		$this->assertFalse($approved);
	}

	/**
	 * "Approval with the ability to edit" is a topic-visibility concept. A single post inside a
	 * topic somebody else owns cannot be hidden that way, so topic mode caps the level.
	 */
	public function test_topic_mode_caps_the_approval_level()
	{
		$helper = $this->create_helper($this->topic_mode([
			'introduciator_posting_approval_level' => introduciator_helper::APPROVAL_LEVEL_APPROVAL_WITH_EDIT,
		]));

		$params = $helper->introduciator_getparams();

		$this->assertSame(introduciator_helper::APPROVAL_LEVEL_APPROVAL, $params['posting_approval_level']);
	}

	public function test_forum_mode_keeps_the_approval_level()
	{
		$helper = $this->create_helper([
			'introduciator_posting_approval_level' => introduciator_helper::APPROVAL_LEVEL_APPROVAL_WITH_EDIT,
		]);

		$params = $helper->introduciator_getparams();

		$this->assertSame(introduciator_helper::APPROVAL_LEVEL_APPROVAL_WITH_EDIT, $params['posting_approval_level']);
	}

	/**
	 * Topic mode does not cache the forum id in the config: it is derived from the topic on every
	 * request, so a moderator moving the topic cannot desynchronise the two.
	 */
	private function topic_mode(array $extra = [])
	{
		return array_merge([
			'introduciator_mode'		=> introduciator_helper::MODE_TOPIC,
			'introduciator_fk_topic_id'	=> 42,
		], $extra);
	}
}
