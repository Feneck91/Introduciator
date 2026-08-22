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
 * Answers a scripted list of result sets, in the order the code under test asks for them, and
 * records how many queries it ran. Enough to drive the read-only lookups without a database.
 */
class scripted_db extends \phpbb\db\driver\factory
{
	/** @var array List of result sets, each a list of rows */
	private $result_sets;

	/** @var array Rows still to hand out, keyed by result handle */
	private $pending = [];

	/** @var int */
	public $queries = 0;

	public function __construct(array $result_sets)
	{
		$this->result_sets = $result_sets;
	}

	public function sql_query($query = '', $cache_ttl = 0)
	{
		$handle = $this->queries++;
		$this->pending[$handle] = isset($this->result_sets[$handle]) ? $this->result_sets[$handle] : [];

		return $handle;
	}

	public function sql_fetchrow($query_id = false)
	{
		if (empty($this->pending[$query_id]))
		{
			return false;
		}

		return array_shift($this->pending[$query_id]);
	}

	public function sql_freeresult($query_id = false)
	{
		unset($this->pending[$query_id]);

		return true;
	}

	public function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		return $field . ' IN (' . implode(', ', (array) $array) . ')';
	}
}

/**
 * Blocking a move that would give one member two presentations in the introduce forum. The check
 * runs before move_topics() writes anything, so refusing here leaves nothing half-moved.
 */
class move_duplicate_test extends helper_test_base
{
	public function test_a_move_that_would_duplicate_a_presentation_is_reported()
	{
		$helper = $this->create_helper([], '', introduciator_helper::class, new scripted_db([
			[['topic_id' => 55, 'topic_title' => 'Hi there', 'topic_poster' => 11, 'username' => 'alice', 'user_colour' => 'AA0000']],
			[['topic_id' => 20, 'topic_first_post_id' => 90, 'topic_poster' => 11]],
		]));

		$conflicts = $helper->check_move_creates_duplicate_introduction([55], 7);

		$this->assertCount(1, $conflicts);
		$this->assertSame(55, $conflicts[0]['moved_topic_id']);
		$this->assertSame(11, $conflicts[0]['poster_id']);
		$this->assertSame(20, $conflicts[0]['existing_topic_id']);
		$this->assertSame(90, $conflicts[0]['existing_first_post_id']);
	}

	public function test_a_poster_with_no_presentation_there_is_not_a_conflict()
	{
		$helper = $this->create_helper([], '', introduciator_helper::class, new scripted_db([
			[['topic_id' => 55, 'topic_title' => 'Hi there', 'topic_poster' => 11, 'username' => 'alice', 'user_colour' => '']],
			[],
		]));

		$this->assertSame([], $helper->check_move_creates_duplicate_introduction([55], 7));
	}

	/**
	 * Moving a topic that is already in the introduce forum (a no-op move, or a move between
	 * forums that lands back) must not report the topic as a duplicate of itself.
	 */
	public function test_a_topic_is_never_a_duplicate_of_itself()
	{
		$helper = $this->create_helper([], '', introduciator_helper::class, new scripted_db([
			[['topic_id' => 55, 'topic_title' => 'Hi there', 'topic_poster' => 11, 'username' => 'alice', 'user_colour' => '']],
			[['topic_id' => 55, 'topic_first_post_id' => 90, 'topic_poster' => 11]],
		]));

		$this->assertSame([], $helper->check_move_creates_duplicate_introduction([55], 7));
	}

	/**
	 * Used to be missed: when the poster's first match was the topic being moved, the lookup
	 * stopped there and their real other presentation went unnoticed.
	 */
	public function test_a_second_presentation_behind_the_moved_topic_is_still_found()
	{
		$helper = $this->create_helper([], '', introduciator_helper::class, new scripted_db([
			[['topic_id' => 55, 'topic_title' => 'Hi there', 'topic_poster' => 11, 'username' => 'alice', 'user_colour' => '']],
			[
				['topic_id' => 55, 'topic_first_post_id' => 90, 'topic_poster' => 11],
				['topic_id' => 61, 'topic_first_post_id' => 95, 'topic_poster' => 11],
			],
		]));

		$conflicts = $helper->check_move_creates_duplicate_introduction([55], 7);

		$this->assertCount(1, $conflicts);
		$this->assertSame(61, $conflicts[0]['existing_topic_id']);
	}

	/**
	 * Whatever the number of topics being moved, the check must stay at two queries.
	 */
	public function test_many_moved_topics_still_take_two_queries()
	{
		$moved = [];
		$existing = [];
		foreach (range(1, 25) as $index)
		{
			$moved[] = ['topic_id' => 500 + $index, 'topic_title' => 'T' . $index, 'topic_poster' => $index, 'username' => 'u' . $index, 'user_colour' => ''];
			$existing[] = ['topic_id' => 900 + $index, 'topic_first_post_id' => 800 + $index, 'topic_poster' => $index];
		}

		$db = new scripted_db([$moved, $existing]);
		$helper = $this->create_helper([], '', introduciator_helper::class, $db);

		$conflicts = $helper->check_move_creates_duplicate_introduction(array_column($moved, 'topic_id'), 7);

		$this->assertCount(25, $conflicts);
		$this->assertSame(2, $db->queries, 'The check must not scale its query count with the number of moved topics.');
	}

	public static function disabled_data()
	{
		return [
			'extension disabled'	=> ['introduciator_allow', 0],
			'check disabled'		=> ['introduciator_is_check_move_duplicate', 0],
			'topic mode'			=> ['introduciator_mode', introduciator_helper::MODE_TOPIC],
		];
	}

	/**
	 * @dataProvider disabled_data
	 */
	public function test_the_check_is_a_no_op_when_it_does_not_apply($config_key, $config_value)
	{
		$db = new scripted_db([]);
		$helper = $this->create_helper([$config_key => $config_value], '', introduciator_helper::class, $db);

		$this->assertSame([], $helper->check_move_creates_duplicate_introduction([55], 7));
		$this->assertSame(0, $db->queries, 'Nothing may be queried when the check does not apply.');
	}

	public function test_a_move_into_another_forum_is_a_no_op()
	{
		$db = new scripted_db([]);
		$helper = $this->create_helper([], '', introduciator_helper::class, $db);

		$this->assertSame([], $helper->check_move_creates_duplicate_introduction([55], 8));
		$this->assertSame(0, $db->queries);
	}

	public function test_an_empty_move_is_a_no_op()
	{
		$db = new scripted_db([]);
		$helper = $this->create_helper([], '', introduciator_helper::class, $db);

		$this->assertSame([], $helper->check_move_creates_duplicate_introduction([], 7));
		$this->assertSame(0, $db->queries);
	}
}
