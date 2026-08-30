<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace feneck91\introduciator\helper;

/**
 * Class used to manage extension.
 *
 * Is used to manage ACP and check all needed information to known how the extension should work.
 */
class introduciator_helper
{
	const APPROVAL_LEVEL_NO_APPROVAL          = 0; // No approval introduce
	const APPROVAL_LEVEL_APPROVAL             = 1; // Approval introduce : the user don't see his introduce and cannot edit it
	const APPROVAL_LEVEL_APPROVAL_WITH_EDIT   = 2; // Approval introduce : the user see his introduce and can edit it

	const MODE_FORUM = 0; // Introduce by creating a topic into a dedicated forum (one topic per user)
	const MODE_TOPIC = 1; // Introduce by posting into a single shared topic (one post per user)

	/**
	 * Dummy URLs the %forum_url% / %forum_post% placeholders are swapped for before the
	 * explanation texts go through phpBB's BBCode parser, which rejects a [url] tag whose
	 * content is not a syntactically valid URL. They are swapped back both on display and
	 * when the texts are loaded for editing again.
	 */
	const PLACEHOLDER_URL_FORUM = 'http://aghxkfps.tld';
	const PLACEHOLDER_URL_POST  = 'http://dqsdfzef.tld';

	/**
	 * Seconds after which a posting claim is considered abandoned by a request
	 * that died before releasing it. A submission never legitimately takes this long.
	 */
	const CLAIM_TIMEOUT = 60;

	/**
	 * Directory, relative to the phpBB root, holding the posting claim files.
	 */
	const CLAIM_DIR = 'store/feneck91_introduciator';

	/**
	 * @var string Name of the table that contains groups for externsion's permission.
	 */
	private $table_groups_name;

	/**
	 * @var string Name of the table that contains texts to fill explanation web page.
	 */
	private $table_explanation_name;

	/**
	 * PhpBB Root path.
	 */
	private $root_path;

	/**
	 * phpBB Extension.
	 */
	private $php_ext;

	/**
	 * @var \phpbb\user Current connected user.
	 */
	private $user;

	/**
	 * @var \phpbb\db\driver\factory Database access.
	 */
	private $db;

	/**
	 * @var \phpbb\config\config Current configuration (config table).
	 */
	private $config;

	/**
	 * @var \phpbb\auth\auth Current authorization.
	 */
	private $auth;

	/**
	 * @var \phpbb\controller\helper Controller helper, used to generate links to explanation page.
	 */
	private $controller_helper;

	/**
	 * @var \phpbb\language\language Language manager, used to translate all messages.
	 */
	private $language;

	/**
	 * @var bool Flag indicate if the language is loaded or not.
	 */
	private $language_loaded;

	/**
	 * @var array Current introduciator parameters with key / value.
	 */
	private $introduciator_params;

	/**
	 * @var array|null Cached group IDs from the introduciator groups table, memoized per request.
	 */
	private $groups_selected_cache;

	/**
	 * @var string Path of the posting claim file held by this request, empty if none.
	 */
	private $posting_claim_file = '';

	/**
	 * Constructor
	 *
	 * @param string                    $table_groups_name Name of the table that contains groups for externsion's permission.
	 * @param string                    $table_explanation_name Name of the table that contains texts to fill explanation web page.
	 * @param string                    $root_path phpBB root path.
	 * @param string                    $php_ext phpBB Extension.
	 * @param \phpbb\user               $user Current connected user.
	 * @param \phpbb\db\driver\factory  $db Database access.
	 * @param \phpbb\config\config      $config Current configuration (config table).
	 * @param \phpbb\auth\auth          $auth Current authorizations.
	 * @param \phpbb\controller\helper  $controller_helper Controller helper, used to generate route.
	 * @param \phpbb\language\language  $language Language manager, used to translate all messages.
	 */
	public function __construct($table_groups_name, $table_explanation_name, $root_path, $php_ext, \phpbb\user $user, \phpbb\db\driver\factory $db, \phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\controller\helper $controller_helper, \phpbb\language\language $language)
	{
		$this->table_groups_name = $table_groups_name;
		$this->table_explanation_name = $table_explanation_name;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->user = $user;
		$this->db = $db;
		$this->config = $config;
		$this->auth = $auth;
		$this->controller_helper = $controller_helper;
		$this->language = $language;
		$this->language_loaded = false;
	}

	/**
	 * Load language only if noyt already done.
	 *
	 * @return void
	 * @access public
	 */
	public function load_language()
	{
		if (!$this->language_loaded)
		{
			//$this->language->add_lang('introduciator', 'feneck91/introduciator');	// Add lang
			$this->language_loaded = true;
		}
	}

	/**
	 * Get the language instance.
	 *
	 * Return the private language instance.
	 *
	 * @return \phpbb\language\language
	 * @access public
	 */
	public function get_language()
	{
		return $this->language;
	}

	/**
	 * Is the introduciator enabled?
	 *
	 * Return the introduciator_allow's config field: true if the introduciator is allowed, false else. Read from config['introduciator_allow']:  '0' (false) or '1' or other value (true).
	 *
	 * @return boolean
	 * @access public
	 */
	public function is_introduciator_allowed()
	{
		return (bool) $this->config['introduciator_allow'];
	}

	/**
	 * Compute the url to a specific post.
	 *
	 * It can be used to return the introduction url where to go to the the user introduction.
	 *
	 * Return the url to a specific post.
	 *
	 * @param int $forum_id The forum's identifier.
	 * @param int $topic_id The topic's identifier.
	 * @param int $post_id The post's identifier.
	 *
	 * @return string
	 * @access public
	 */
	public function get_post_url($forum_id, $topic_id, $post_id)
	{
		return append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $forum_id .'&amp;t=' . (int) $topic_id . '#p' . (int) $post_id);
	}

	/**
	 * Get the ids of the groups selected in the ACP.
	 *
	 * The table's content doesn't depend on any argument, so it's read once per request and
	 * memoized: callers that check many groups or many users in a row (the ACP group list, the
	 * statistics page) would otherwise run one query each.
	 *
	 * @return array List of group ids (int)
	 * @access public
	 */
	public function get_selected_group_ids()
	{
		if ($this->groups_selected_cache === null)
		{
			$sql = 'SELECT fk_group
					FROM ' . $this->table_groups_name;

			$result = $this->db->sql_query($sql);

			$arr_groups_id = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$arr_groups_id[] = (int) $row['fk_group'];
			}
			$this->db->sql_freeresult($result);

			$this->groups_selected_cache = $arr_groups_id;
		}

		return $this->groups_selected_cache;
	}

	/**
	 * Check if a group is selected.
	 *
	 * Return true if the group is selected, false else.
	 *
	 * @param int $group_id Group's identifier.

	 * @return boolean
	 * @access public
	 */
	public function is_group_selected($group_id)
	{
		return in_array((int) $group_id, $this->get_selected_group_ids(), true);
	}

	/**
	 * Replace all variables with several values.
	 *
	 * Example :
	 * 	replace_all_by(
	 *		[
	 *			&$var_1,
	 *			&$var_2
	 *		],
	 *		[
	 *			'search1'	=> 'replaced by this text1',
	 *			'search2'	=> 'replaced by this text2',
	 *			'search3'	=> 'replaced by this text3',
	 *		]);
	 *
	 * @param array $arr_fields Array of variables to update
	 * @param array $arr_replace_by Array of maps with key is the text to replace, value is the text to replace with
	 *
	 * @return void
	 * @access public
	 */
	public function replace_all_by($arr_fields, $arr_replace_by)
	{
		foreach ($arr_fields as &$field)
		{
			foreach ($arr_replace_by as $arr_replace_by_key => $arr_replace_by_value)
			{
				$field = str_replace($arr_replace_by_key, $arr_replace_by_value, $field);
			}
		}
	}

	/**
	 * Build the map that turns the dummy URLs back into the %forum_url% / %forum_post%
	 * placeholders the admin typed.
	 *
	 * Boards still on the legacy BBCode storage keep the URL entity-escaped inside [url]
	 * tags (see bbcode_specialchars() in includes/message_parser.php), while the s9e
	 * TextFormatter storage used since phpBB 3.2 gives the plain form back. Both are
	 * restored, so the placeholders survive a save / re-edit round trip either way.
	 *
	 * @return array Map of text to search for => placeholder to restore
	 * @access public
	 * @static
	 */
	public static function get_placeholder_restore_map()
	{
		$escaped = str_replace([':', '.'], ['&#58;', '&#46;'], [self::PLACEHOLDER_URL_FORUM, self::PLACEHOLDER_URL_POST]);

		return [
			$escaped[0]						=> '%forum_url%',
			$escaped[1]						=> '%forum_post%',
			self::PLACEHOLDER_URL_FORUM		=> '%forum_url%',
			self::PLACEHOLDER_URL_POST		=> '%forum_post%',
		];
	}

	/**
	 * Get the explanations informations.
	 *
	 * Return an array of explanation text used to edit or display.
	 *
	 * @param boolean $is_edit if true, return rules texts for editing
	 *                         else return rules texts for display
	 * @param boolean $only_current_lang if true, return only user's default language.
	 *                                   else return alls languages (used only in the extension configuration and to display all rules in all languages)
	 *
	 * @return array
	 * @access public
	 */
	public function introduciator_get_explanations($is_edit, $only_current_lang)
	{
		$arr_request = [
			'SELECT'    => 'l.lang_iso, l.lang_local_name, e.*',
			'FROM'      => [LANG_TABLE => 'l'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->table_explanation_name => 'e'],
					'ON'	=> 'e.lang = l.lang_iso'
				]
			],
			'ORDER BY'	=> 'l.lang_id',
		];

		if ($only_current_lang === true)
		{
			// Add WHERE to get only the current user language
			$arr_request = array_merge($arr_request, [
				'WHERE'		=> "l.lang_iso = '{$this->db->sql_escape($this->user->lang_name)}'",
			]);
		}

		$sql = $this->db->sql_build_query('SELECT', $arr_request);
		$ret_value = [];
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$message_title					= isset($row['message_title']) ? $row['message_title'] : '%explanation_title%';
			$message_title_uid				= isset($row['message_title_uid']) ? $row['message_title_uid'] : '';
			$message_title_bitfield 		= isset($row['message_title_bitfield']) ? $row['message_title_bitfield'] : '';
			$message_title_bbcode_options 	= isset($row['message_title_bbcode_options']) ? $row['message_title_bbcode_options'] : '';
			$message_text					= isset($row['message_text']) ? $row['message_text'] : '%explanation_text%';
			$message_text_uid				= isset($row['message_text_uid']) ? $row['message_text_uid'] : '';
			$message_textbitfield			= isset($row['message_text_bitfield']) ? $row['message_text_bitfield'] : '';
			$message_text_bbcode_options 	= isset($row['message_text_bbcode_options']) ? $row['message_text_bbcode_options'] : '';

			$rules_title					= isset($row['rules_title']) ? $row['rules_title'] : '%rules_title%';
			$rules_title_uid				= isset($row['rules_title_uid']) ? $row['rules_title_uid'] : '';
			$rules_title_bitfield			= isset($row['rules_title_bitfield']) ? $row['rules_title_bitfield'] : '';
			$rules_title_bbcode_options		= isset($row['rules_title_bbcode_options']) ? $row['rules_title_bbcode_options'] : '';
			$rules_text						= isset($row['rules_text']) ? $row['rules_text'] : '%rules_text%';
			$rules_text_uid					= isset($row['rules_text_uid']) ? $row['rules_text_uid'] : '';
			$rules_textbitfield				= isset($row['rules_text_bitfield']) ? $row['rules_text_bitfield'] : '';
			$rules_text_bbcode_options		= isset($row['rules_text_bbcode_options']) ? $row['rules_text_bbcode_options'] : '';

			// Plain text, unlike the fields above: no BBCode, so no uid/bitfield/options to decode
			$topic_title_template			= isset($row['topic_title_template']) ? $row['topic_title_template'] : '';

			if ($is_edit)
			{
				$message_title = generate_text_for_edit($message_title, $message_title_uid, (int) $message_title_bbcode_options);
				$message_text = generate_text_for_edit($message_text, $message_text_uid, (int) $message_text_bbcode_options);
				$rules_title = generate_text_for_edit($rules_title, $rules_title_uid, (int) $rules_title_bbcode_options);
				$rules_text = generate_text_for_edit($rules_text, $rules_text_uid, (int) $rules_text_bbcode_options);

				$message_title = $message_title['text'];
				$message_text = $message_text['text'];
				$rules_title = $rules_title['text'];
				$rules_text = $rules_text['text'];

				// Restore %forum_url% and %forum_post% tags because we must change them else the BBCode URL not work if the URL is not correct
				$this->replace_all_by(
					[
						&$message_title,
						&$message_text,
						&$rules_title,
						&$rules_text,
					],
					self::get_placeholder_restore_map());

				$ret_value[] = [
					'lang_local_name'		=>	$row['lang_local_name'],
					'lang_iso'				=> 	$row['lang_iso'],
					'explanation'			=> [
						'edit_message_title'	=> $message_title,
						'edit_message_text'		=> $message_text,
						'edit_rules_title'		=> $rules_title,
						'edit_rules_text'		=> $rules_text,
						'edit_topic_title_template'	=> $topic_title_template,
					],
				];
			}
			else
			{
				$ret_value[] = [
					'lang_local_name'		=>	$row['lang_local_name'],
					'lang_iso'				=> 	$row['lang_iso'],
					'explanation'			=> [
						'message_title'					=> $message_title,
						'message_title_uid'				=> $message_title_uid,
						'message_title_bitfield'		=> $message_title_bitfield,
						'message_title_bbcode_options'	=> $message_title_bbcode_options,
						'message_text'					=> $message_text,
						'message_text_uid'				=> $message_text_uid,
						'message_text_bitfield'			=> $message_textbitfield,
						'message_text_bbcode_options' 	=> $message_text_bbcode_options,
						'rules_title'					=> $rules_title,
						'rules_title_uid'				=> $rules_title_uid,
						'rules_title_bitfield'			=> $rules_title_bitfield,
						'rules_title_bbcode_options'	=> $rules_title_bbcode_options,
						'rules_text'					=> $rules_text,
						'rules_text_uid'				=> $rules_text_uid,
						'rules_text_bitfield'			=> $rules_textbitfield,
						'rules_text_bbcode_options'		=> $rules_text_bbcode_options,
						'topic_title_template'			=> $topic_title_template,
					],
				];
			}
		}
		$this->db->sql_freeresult($result);

		return $ret_value;
	}

	/**
	 * Get the introduciator parameters.
	 *
	 * Return the introduciator parameters.
	 *
	 * @param boolean $is_edit if true, return rules texts for editing
	 *                         if false, return rules texts for display
	 *                         if null, don't return rules texts (used only in the extension configuration and to display rules)
	 *
	 * @return array
	 * @access public
	 */
	public function introduciator_getparams($is_edit = null)
	{
		$mode = (int) $this->config['introduciator_mode'];
		$fk_topic_id = (int) $this->config['introduciator_fk_topic_id'];
		$fk_forum_id = (int) $this->config['introduciator_fk_forum_id'];
		$topic_title = '';

		if ($mode === self::MODE_TOPIC && $fk_topic_id)
		{
			// The forum is derived from the topic on every request rather than cached in config,
			// so a moderator moving the topic doesn't silently desynchronize the two.
			$sql = 'SELECT forum_id, topic_title
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . $fk_topic_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row)
			{
				$fk_forum_id = (int) $row['forum_id'];
				$topic_title = $row['topic_title'];
			}
		}

		$posting_approval_level = (int) $this->config['introduciator_posting_approval_level'];
		if ($mode === self::MODE_TOPIC)
		{
			// Approval with edit is a topic-visibility concept; it has no meaning for a single
			// post inside a shared topic, so it's never offered above APPROVAL_LEVEL_APPROVAL here.
			$posting_approval_level = min($posting_approval_level, self::APPROVAL_LEVEL_APPROVAL);
		}

		$params = [
			'introduciator_allow'					=>        $this->is_introduciator_allowed(),
			'mode'									=>        $mode,
			'fk_forum_id'							=> (int) $fk_forum_id,
			'fk_topic_id'							=> (int) $fk_topic_id,
			'is_introduction_mandatory'				=> (bool) $this->config['introduciator_is_introduction_mandatory'],
			'is_check_delete_first_post'			=> (bool) $this->config['introduciator_is_check_delete_first_post'],
			'is_check_move_duplicate'				=> (bool) $this->config['introduciator_is_check_move_duplicate'],
			'is_explanation_enabled'				=> (bool) $this->config['introduciator_is_explanation_enabled'],
			'is_use_permissions'					=> (bool) $this->config['introduciator_is_use_permissions'],
			'is_include_groups'						=> (bool) $this->config['introduciator_is_include_groups'],
			'ignored_users'							=>        $this->config['introduciator_ignored_users'],
			'is_explanation_display_rules'			=> (bool) $this->config['introduciator_is_explanation_display_rules'],
			'posting_approval_level'				=>        $posting_approval_level,
		];

		if ($is_edit === true || $is_edit === false)
		{
			$forum_name = '';
			// Filled in from the configured forum below. Kept complete even when that forum no
			// longer exists (deleted after being configured), so the display path can read every
			// key unconditionally.
			$forum_rules = [
				'rules'				=> '',
				'rules_uid'			=> '',
				'rules_bitfield'	=> '',
				'rules_options'		=> 0,
			];

			if ($params['introduciator_allow'])
			{
				if ($mode === self::MODE_TOPIC)
				{
					$forum_name = $topic_title;

					if ($fk_forum_id)
					{
						$sql = 'SELECT forum_rules, forum_rules_uid, forum_rules_bitfield, forum_rules_options
								FROM ' . FORUMS_TABLE . '
								WHERE forum_id = ' . (int) $fk_forum_id;
						$result = $this->db->sql_query($sql);
						$row = $this->db->sql_fetchrow($result);

						if ($row)
						{
							$forum_rules = [
								'rules'				=> $row['forum_rules'],
								'rules_uid'			=> $row['forum_rules_uid'],
								'rules_bitfield'	=> $row['forum_rules_bitfield'],
								'rules_options'		=> $row['forum_rules_options'],
							];
						}
						$this->db->sql_freeresult($result);
					}
				}
				else
				{
					// Find Forum name
					$sql = 'SELECT forum_name, forum_rules, forum_rules_uid, forum_rules_bitfield, forum_rules_options
							FROM ' . FORUMS_TABLE . '
							WHERE forum_id = ' . (int) $params['fk_forum_id'];
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);

					if ($row)
					{
						$forum_name = $row['forum_name'];
						$forum_rules = [
							'rules'				=> $row['forum_rules'],
							'rules_uid'			=> $row['forum_rules_uid'],
							'rules_bitfield'	=> $row['forum_rules_bitfield'],
							'rules_options'		=> $row['forum_rules_options'],
						];
					}
					$this->db->sql_freeresult($result);
				}
			}

			if ($is_edit)
			{
				$params = array_merge($params, [
					'explanations' => $this->introduciator_get_explanations($is_edit, false),
				]);
			}
			else
			{
				// Load langage
				$this->load_language();

				// Only one into explanation (the user default language)
				foreach ($this->introduciator_get_explanations($is_edit, true) as $explanation_value)
				{
					$explanation = $explanation_value['explanation'];

					if ($mode === self::MODE_TOPIC)
					{
						$forum_url = append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $fk_forum_id . '&amp;t=' . (int) $fk_topic_id);
						$forum_post = append_sid("{$this->root_path}posting.{$this->php_ext}", 'mode=reply&amp;f=' . (int) $fk_forum_id . '&amp;t=' . (int) $fk_topic_id);
						$message_text_lang_key = 'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_TOPIC';
						$link_goto_lang_key = 'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_TOPIC';
					}
					else
					{
						$forum_url = append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $params['fk_forum_id']);
						$forum_post = append_sid("{$this->root_path}posting.{$this->php_ext}", 'mode=post&amp;f=' . (int) $params['fk_forum_id']);
						$message_text_lang_key = 'INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT';
						$link_goto_lang_key = 'INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM';
					}
					// Generate all string to be displayed
					$explanation_message_title = generate_text_for_display($explanation['message_title'], $explanation['message_title_uid'], $explanation['message_title_bitfield'], $explanation['message_title_bbcode_options']);
					$explanation_message_text = generate_text_for_display($explanation['message_text'], $explanation['message_text_uid'], $explanation['message_text_bitfield'], $explanation['message_text_bbcode_options']);
					$explanation_rules_title = generate_text_for_display($explanation['rules_title'], $explanation['rules_title_uid'], $explanation['rules_title_bitfield'], $explanation['rules_title_bbcode_options']);
					$explanation_rules_text = generate_text_for_display($explanation['rules_text'], $explanation['rules_text_uid'], $explanation['rules_text_bitfield'], $explanation['rules_text_bbcode_options']);
					$explanation_message_title = str_replace('%explanation_title%', $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'), $explanation_message_title);
					$explanation_message_text = str_replace('%explanation_text%', $this->language->lang($message_text_lang_key, $forum_url, $forum_name) . (($params['is_explanation_display_rules'] && $explanation_message_text != '' && $explanation_rules_text != '') ? $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES') : ''), $explanation_message_text);
					$explanation_rules_title = str_replace('%rules_title%', $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'), $explanation_rules_title);
					$explanation_rules_text = str_replace('%rules_text%', generate_text_for_display($forum_rules['rules'], $forum_rules['rules_uid'], $forum_rules['rules_bitfield'], $forum_rules['rules_options']), $explanation_rules_text);
					$link_goto_forum = $this->language->lang($link_goto_lang_key, $forum_name);
					$link_post_forum = $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM');

					// Replace in each string the predefined fields
					$this->replace_all_by(
						[
							&$explanation_message_title,
							&$explanation_message_text,
							&$explanation_rules_title,
							&$explanation_rules_text,
						],
						[
							'%forum_name%'			=> $forum_name,
							self::PLACEHOLDER_URL_FORUM	=> $forum_url,	// Restore correct link
							self::PLACEHOLDER_URL_POST	=> $forum_post,	// Restore correct link
						]
					);

					// Make links into $link_goto_forum / $link_post_forum
					$this->replace_all_by(
						[
							&$explanation_message_title,		// if text is from $this->language->lang(xx),
							&$explanation_message_text,
							&$explanation_rules_title,
							&$explanation_rules_text,
							&$link_goto_forum,
							&$link_post_forum,
						],
						[
							'%forum_name%'	=> $forum_name,
							'%forum_url%'	=> $forum_url,
							'%forum_post%'	=> $forum_post,
						]
					);

					$params = array_merge($params, [
						'explanation_message_title'				=> $explanation_message_title,
						'explanation_message_text'				=> $explanation_message_text,
						'explanation_rules_title'				=> $explanation_rules_title,
						'explanation_rules_text'				=> $explanation_rules_text,
						'explanation_message_goto_forum'		=> $link_goto_forum,
						'explanation_message_post_forum'		=> $link_post_forum,
						'forum_name'							=> $forum_name,
						'forum_url'								=> $forum_url,
						'forum_post'							=> $forum_post,
					]);
				}
			}
		}

		return $params;
	}

	/**
	 * Verify if the posting is allowed or not.
	 *
	 * If not allowed, it redirect the current page to the introduce forum or the explanation page
	 * or error message if action is not allowed.
	 *
	 * Return true if the user is allowed to make action,
	 *        false else, in this case, just check if allowed or not (remove quick reply if not allowed).
	 *
	 * @param string			$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
	 * @param int				$forum_id	Forum identifier where the user try to post.
	 * @param int				$post_id	Post's id: it cannot be deleted if it is the first one and action is delete (used only for delete), pass 0 else.
	 * @param array				$post_data	Informations about posting (used only for delete) pass null else.
	 * @param boolean			$redirect	true if the function should redirect in case of the user is not allowed to make the action, else only return status.
	 * @param boolean			$claim_slot	true only when called from the actual submission path (not from a display-only
	 *										check): claims an atomic slot to guard against a concurrent duplicate introduction.
	 * @param int				$topic_id	Topic identifier where the user try to post, 0 if not applicable (new topic).
	 *
	 * @return boolean
	 * @access public
	 */
	public function user_can_post($mode, $forum_id, $post_id, $post_data, $redirect, $claim_slot = false, $topic_id = 0)
	{
		$poster_id = (int) $this->user->data['user_id'];
		$ret_allowed_action = true;

		if ($poster_id != ANONYMOUS)
		{
			// User is logged and have user authorization
			if ($this->is_introduciator_allowed())
			{
				// Extension is enabled and the user is not ignored, it can do all he wants
				// Force forum id because it be moved while user delete the message
				if (empty($this->introduciator_params))
				{
					$this->introduciator_params = $this->introduciator_getparams();
				}

				if (in_array($mode, array('delete', 'soft_delete')))
				{
					// The delete-protection below only makes sense when an introduction is "the first
					// post of a dedicated topic". In topic mode, the topic's first post belongs to
					// whoever created the shared topic, not to any single introducer, and deleting
					// one's own post there just puts the user back into "must introduce" state.
					if ($this->introduciator_params['mode'] == self::MODE_FORUM)
					{
						// Check if the user don't try to remove the first message of it's OWN introduce
						// Don't care about is_user_ignored / is_user_must_introduce_himself => Administrator / Moderator cannot delete first posts of presentation
						// else he needs to delete all the topic
						$forum_id = (!empty($post_data['forum_id'])) ? (int) $post_data['forum_id'] : (int) $forum_id;
						$post_id  = (!empty($post_data['post_id'])) ? (int) $post_data['post_id'] : (int) $post_id;

						if (!empty($post_id) && !empty($post_data['topic_id']) && ((int) $this->introduciator_params['fk_forum_id']) == $forum_id && $this->introduciator_params['is_check_delete_first_post'] && $this->user->data['is_registered'] && $this->auth->acl_gets('f_delete', 'm_delete', (int) $forum_id))
						{
							// This post is into the introduce forum
							// Find the topic identifier
							$sql = 'SELECT topic_id, poster_id
									FROM ' . POSTS_TABLE . '
									WHERE post_id = ' . (int) $post_id;

							$result = $this->db->sql_query($sql);
							$row = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);
							// A moderator can be looking at a post that no longer exists by the time
							// this runs, so never assume the row came back.
							$topic_id_of_post = $row ? (int) $row['topic_id'] : 0;
							$first_poster_id = $row ? (int) $row['poster_id'] : 0;	// <-- $poster_id could be <> from current user id
																		// It's this case when moderator try to delete post of another user

							if (!empty($topic_id_of_post) && !empty($first_poster_id))
							{
								// Check if this post is the first one, ie this is the post that created the Topic
								$topic_first_post_id = (int) $post_data['topic_first_post_id'];

								if (!empty($topic_first_post_id) && $topic_first_post_id == $post_id)
								{
									// Check if the topic contains more than one post: if contains only one post, keep default behavior
									$sql = 'SELECT COUNT(*) AS posts_count
											FROM ' . POSTS_TABLE . '
											WHERE topic_id = ' . (int) $topic_id_of_post . ' AND post_visibility <> ' . ITEM_DELETED;

									$result = $this->db->sql_query($sql);
									$row = $this->db->sql_fetchrow($result);
									$this->db->sql_freeresult($result);
									$posts_count = (int) $row['posts_count'];

									if ($posts_count > 1)
									{
										// The user try to delete the first post of one introduce topic : may be not allowed
										// Even the the $first_poster_id is ignored, no way to delete the first post of any introduction of any users
										// if the configuration option (authorize extension to verify the deletion of first post introduction) is selected
										$ret_allowed_action = false;
										if ($redirect)
										{
											// Load langage
											$this->user->setup('posting'); // Mandatory here else all forum is not in same language as user's one
											$this->load_language();

											$message = $first_poster_id === $poster_id && !$this->auth->acl_get('m_delete', $forum_id) ? $this->language->lang('INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST') : $this->language->lang('INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST');
											$meta_info = append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $forum_id . '&amp;t=' . (int) $topic_id_of_post);
											$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_TOPIC'), '<a href="' . $meta_info . '">', '</a>');
											$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_FORUM'), '<a href="' . append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $forum_id) . '">', '</a>');
											trigger_error($message, E_USER_NOTICE);
										}
									}
								}
							}
						}
					}
				}
				else if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					$topic_introduce_id = 0;
					$introduce_post_id = 0;
					$post_approved = false;

					if (!$this->has_user_introduced($poster_id, $topic_introduce_id, $introduce_post_id, $post_approved))
					{
						// No post into the introduce topic
						if ($this->introduciator_params['is_introduction_mandatory'] && in_array($mode, ['post', 'reply', 'quote']) && !$this->is_introduction_action($mode, $forum_id, $topic_id))
						{
							$ret_allowed_action = false;
							// Make these test ONLY if the introduction is mandatory (is_introduction_mandatory) else ignore all, the user post even he is not introduce
							if ($redirect)
							{
								if ($this->introduciator_params['is_explanation_enabled'])
								{
									redirect($this->controller_helper->route('feneck91_introduciator_explain', ['forum_id' => (int) $forum_id]));
								}
								else
								{
									redirect($this->get_introduction_url());
								}
							}
						}
						else if ($claim_slot && $this->is_introduction_action($mode, $forum_id, $topic_id))
						{
							// About to allow creating a brand new introduction topic: claim an atomic
							// slot first so that a concurrent duplicate submission (double click, slow
							// network resubmit, two tabs, back button + resubmit) cannot also fall
							// through and create a second one.
							if (!$this->claim_introduction_slot($poster_id))
							{
								$ret_allowed_action = false;
								if ($redirect)
								{
									// Load langage
									$this->user->setup('posting'); // Mandatory here else all forum is not in same language as user's one
									$this->load_language();

									$message = $this->language->lang('INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE');
									$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_FORUM'), '<a href="' . $this->get_introduction_url() . '">', '</a>');
									trigger_error($message, E_USER_NOTICE);
								}
							}
						}
					}
					else if (!$post_approved && in_array($mode, ['reply', 'quote', 'post']))
					{
						// At least one post but not approved !
						if (($this->introduciator_params['is_introduction_mandatory'] || (!$this->introduciator_params['is_introduction_mandatory'] && $this->is_introduction_scope($forum_id, $topic_id)))
							&& (!in_array($mode, ['reply', 'quote']) || !$this->auth->acl_get('m_approve', $forum_id) || !$this->is_introduction_scope($forum_id, $topic_id) || $this->introduciator_params['posting_approval_level'] != $this::APPROVAL_LEVEL_APPROVAL_WITH_EDIT))
						{
							// If is_introduction_mandatory is false the user can do what he wants in other forums that introduce one, else the rules are same (as is_introduction_mandatory = true).
							// Can quote / reply if the user is allowed to approval this introduction (moderator) -> Right of reply or quote is done by the framework,
							// here we just test if right are approve to don't show next message: here, the right are not correct => display the message
							$ret_allowed_action = false;
						}

						if (!$ret_allowed_action && $redirect)
						{
							// Load langage
							$this->user->setup('posting'); // Mandatory here else all forum is not in same language as user's one
							$this->load_language();

							// Test : if the user try to quote / reply into his own introduction : change the message
							if (!empty($post_data['topic_id']) && $post_data['topic_id'] == $topic_introduce_id)
							{
								$message = $this->language->lang('INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION_ONLY_EDIT');
							}
							else
							{
								// Make these test ONLY if the introduction is mandatory (is_introduction_mandatory) else ignore all, the user post even he is not introduce
								$message = $this->language->lang('INTRODUCIATOR_EXT_INTRODUCE_WAITING_APPROBATION');
							}

							$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_FORUM'), '<a href="' . append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . $forum_id) . '">', '</a>');
							trigger_error($message, E_USER_NOTICE);
						}
					}
					else if ($this->introduciator_params['mode'] == self::MODE_FORUM && $forum_id == $this->introduciator_params['fk_forum_id'] && $mode == 'post')
					{
						// User try to create more than one introduce post.
						// Topic mode has no equivalent: once approved, replying again in the shared
						// topic is always allowed (see decision on duplicates in the topic-mode plan).
						$ret_allowed_action = false;
						if ($redirect)
						{
							// Load langage
							$this->user->setup('posting'); // Mandatory here else all forum is not in same language as user's one
							$this->load_language();

							$message = $this->language->lang('INTRODUCIATOR_EXT_INTRODUCE_MORE_THAN_ONCE');
							$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_FORUM'), '<a href="' . append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $forum_id) . '">', '</a>');
							trigger_error($message, E_USER_NOTICE);
						}
					}
				}
			}
		}

		return $ret_allowed_action;
	}

	/**
	 * Get informations about the user.
	 *
	 * Is used by several pages to display link to the member presentation. It indicate if the user has introduce himself or not,
	 * the text and tooltip info, etc.
	 *
	 * Return an array with :
	 * <ul>
	 *   <li>display : true if the user must introduce himself, false else.</li>
	 *   <li>url : url to member introduction, empty string if user has no presentation.</li>
	 *   <li>text : Text used to display the tooltip for the button.</li>
	 *   <li>class : class to use for the button.</li>
	 *   <li>pending : true if message is pending approval, false else.</li>
	 * </ul>.
	 *
	 * @param int		$poster_id		The poster id
	 * @param string	$poster_name	The poster name
	 *
	 * @return array
	 * @access public
	 */
	public function introduciator_get_user_infos($poster_id, $poster_name)
	{
		$display = false;
		$url = false;
		$text = '';
		$class = '';
		$pending = false;

		if ($this->is_introduciator_allowed())
		{
			if (empty($this->introduciator_params))
			{
				$this->introduciator_params = $this->introduciator_getparams();
			}

			if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $poster_name))
			{
				$display = true;
				$topic_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				// Load langage
				$this->load_language();

				if (!$this->has_user_introduced((int) $poster_id, $topic_id, $first_post_id, $topic_approved))
				{
					// No post into the introduce topic
					$text = $this->language->lang('INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION');
					$class = 'introdno-icon';
				}
				else if ($topic_approved)
				{
					$text = $this->language->lang('INTRODUCIATOR_TOPIC_VIEW_PRESENTATION');
					$url = $this->get_post_url($this->introduciator_params['fk_forum_id'], $topic_id, $first_post_id);
					$class = 'introd-icon';
				}
				else
				{
					$text = $this->language->lang('INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION');
					$pending = true;
					if ($this->auth->acl_get('m_approve', $this->introduciator_params['fk_forum_id']) || ($this->introduciator_params['posting_approval_level'] == $this::APPROVAL_LEVEL_APPROVAL_WITH_EDIT && $poster_id == (int) $this->user->data['user_id']))
					{
						// Display url if user can approve the introduction of this user
						// or if the current user is the poster (the user can see its own presentation) AND the extension configuration is APPROVAL_LEVEL_APPROVAL_WITH_EDIT
						$url = append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $this->introduciator_params['fk_forum_id'] . '&amp;t=' . (int) $topic_id . '#p' . (int) $first_post_id);
						$class = 'introdpu-icon';
					}
					else
					{
						$class = 'introdpd-icon';
					}
				}
			}
		}

		return [
			'display'		=> $display,
			'url'			=> $url,
			'text'			=> $text,
			'class'			=> $class,
			'pending'		=> $pending,
		];
	}

	/**
	 * Verify if the posting must be approved or not.
	 *
	 * If the user that post have right to approved it's own presentation,
	 * the function return always false: no need to make manage approval to a user
	 * that can approve himself its own message.
	 *
	 * Return true if the post must be approved, false else.
	 *
	 * @param string			$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
	 * @param int				$forum_id	Forum identifier where the user try to post
	 * @param int				$topic_id	Topic identifier where the user try to post, 0 if not applicable
	 *
	 * @return boolean
	 * @access public
	 */
	public function post_need_approval($mode, $forum_id, $topic_id = 0)
	{
		return !$this->auth->acl_get('m_approve', $forum_id) && $this->get_post_approval_level($mode, $forum_id, $topic_id) != $this::APPROVAL_LEVEL_NO_APPROVAL;
	}

	/**
	 * Replace only first occurrence of string in string.
	 *
	 * @param string	$str_find			String to find
	 * @param string	$str_replacement	String to replace
	 * @param string	$string				String where to find / replace
	 *
	 * @return string
	 * @access public
	 */
	private function str_replace_once($str_find, $str_replacement, $string)
	{
		$pos = strpos($string, $str_find);
		if ($pos !== false)
		{
			$string = substr_replace($string, $str_replacement, $pos, strlen($str_find));
		}

		return $string;
	}

	/**
	 * Generate the request to make topic visible to user when the topic owned by the user and is into
	 * approval state (only for APPROVAL_LEVEL_APPROVAL_WITH_EDIT configuration).
	 *
	 * Return the SQL modified request to be able to see the unapproved user presentation.
	 *
	 * @param int				$forum_id			Forum identifier to be displayed or null to don't filter on forum's id
	 * @param string			$sql_approved		Current sql approved.
	 * @param string			$table_name			Table name used for SQL request, it can be 't' ou 'p' or other. Empty if not needed.
	 * @param array				$approve_fid_ary	Used to retrieve approve_fid_ary if needed, else pass null to ignore parameter.
	 *
	 * @return string
	 * @access public
	 */
	public function introduciator_generate_sql_approved_for_forum($forum_id, $sql_approved, $table_name, &$approve_fid_ary = null)
	{
		if (!empty($sql_approved) && $this->is_introduciator_allowed())
		{
			// Introduciator is activated and $sql_approved has filter
			if (empty($this->introduciator_params))
			{
				// Retrieve extension parameters
				$this->introduciator_params = $this->introduciator_getparams();
			}

			if (($forum_id === null || $this->introduciator_params['fk_forum_id'] == $forum_id) && $this->introduciator_params['posting_approval_level'] == $this::APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
			{
				$poster_id = (int) $this->user->data['user_id'];
				if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					$topic_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if ($this->has_user_introduced($poster_id, $topic_id, $first_post_id, $topic_approved) && !$topic_approved)
					{
						// Post into this introduce topic
						$sql_approved = $this->str_replace_once('AND (t.topic_visibility', 'AND ((t.topic_visibility', $sql_approved) . ' OR ' . (empty($table_name) ? '' : $table_name . '.') . 'topic_id = ' . (int) $topic_id . ')';
						if ($approve_fid_ary !== null)
						{
							$approve_fid_ary = [$topic_id];
						}
					}
				}
			}
		}

		return $sql_approved;
	}

	/**
	 * Test if the topic into the forum is unapproved and contains current introduce of logged user.
	 *
	 * This function is used only for APPROVAL_LEVEL_APPROVAL_WITH_EDIT level.
	 *
	 * Return true if the topic_id is the presentation of the logged user and is not yet approved.
	 * If should return true and check_moderator_permissions is set to true, this function also return false if the user has moderator privilege (to
	 * let approval fields visible).
	 *
	 * @param int				$forum_id						Forum identifier
	 * @param int				$topic_id						topic identifier
	 * @param boolean			$check_moderator_permissions	If set to true, the function check moderator permissions to reply true or false.
	 *
	 * @return boolean
	 * @access public
	 */
	public function introduction_is_unapproved_topic($forum_id, $topic_id, $check_moderator_permissions)
	{
		$ret = false;
		if ($this->is_introduciator_allowed())
		{
			// Introduciator is activated
			if (empty($this->introduciator_params))
			{
				// Retrieve extension parameters
				$this->introduciator_params = $this->introduciator_getparams();
			}

			if ($this->introduciator_params['fk_forum_id'] == $forum_id && $this->introduciator_params['posting_approval_level'] == $this::APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
			{
				$poster_id = (int) $this->user->data['user_id'];
				if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					$topic_introduce_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if ($this->has_user_introduced($poster_id, $topic_introduce_id, $first_post_id, $topic_approved) && !$topic_approved && $topic_id == $topic_introduce_id)
					{
						// Post into this introduce forum, retrieve informations about topic_id and topic approved or not
						// This topic is unapproved and is the introduce of the current logged user
						$ret = $check_moderator_permissions ? !$this->auth->acl_get('m_approve', $forum_id) : true;
					}
				}
			}
		}

		return $ret;
	}

	/**
	 * Check if the user have already posted into this forum.
	 *
	 * It must be the creator of one topic into the configured forum.
	 *
	 * Return true if the user already post at least one message into this forum, false else.
	 *
	 * @param int		$forum_id			Forum's ID
	 * @param int		$user_id			User's ID
	 * @param int		$topic_id			If this function returns true, it contains the Topic ID where the user hast post it's presentation
	 * @param int		$first_post_id		If this function returns true, it contains the post ID of the post that has created the topic
	 * @param boolean	$topic_approved		If this function returns true, it contains true / false if the topic is approved or not
	 *
	 * @return boolean
	 * @access protected
	 */
	protected function is_user_post_into_forum($forum_id, $user_id, &$topic_id, &$first_post_id, &$topic_approved)
	{
		// Visibility state : ITEM_UNAPPROVED / ITEM_APPROVED / ITEM_DELETED / ITEM_REAPPROVE
		// A user can end up with more than one topic here (they existed before the extension was
		// enabled, or a moderator moved one in), so order explicitly and take the oldest rather
		// than letting the database pick.
		$sql = 'SELECT topic_id, topic_first_post_id, topic_visibility
				FROM ' . TOPICS_TABLE . '
				WHERE topic_poster = ' . (int) $user_id . '
				 AND topic_type = ' . POST_NORMAL . '
				 AND forum_id = ' . (int) $forum_id . '
				 AND topic_visibility <> ' . ITEM_DELETED . '
				 AND topic_first_post_id <> 0
				ORDER BY topic_id'; // PATCH : Sometimes, the topic_first_post_id is 0

		$result = $this->db->sql_query_limit($sql, 1);
		$topic_row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if ($topic_row !== false)
		{
			$topic_id = $topic_row['topic_id'];
			$first_post_id = $topic_row['topic_first_post_id'];
			$topic_approved = $topic_row['topic_visibility'] == ITEM_APPROVED; // Change into phpBB 3.1.x => topic_approved replaced by topic_visibility
		}

		return $topic_row !== false; // Return true or false
	}

	/**
	 * Check if the user have already posted into the shared introduction topic (topic mode).
	 *
	 * Return true if the user already posted at least one message into this topic, false else.
	 *
	 * @param int		$topic_id			Topic's ID
	 * @param int		$user_id			User's ID
	 * @param int		$post_id			If this function returns true, it contains the post ID of the user's first post in this topic
	 * @param boolean	$post_approved		If this function returns true, it contains true / false if that post is approved or not
	 *
	 * @return boolean
	 * @access protected
	 */
	protected function is_user_post_into_topic($topic_id, $user_id, &$post_id, &$post_approved)
	{
		$sql = 'SELECT post_id, post_visibility
				FROM ' . POSTS_TABLE . '
				WHERE topic_id = ' . (int) $topic_id . '
				 AND poster_id = ' . (int) $user_id . '
				 AND post_visibility <> ' . ITEM_DELETED . '
				ORDER BY post_id ASC';

		$result = $this->db->sql_query_limit($sql, 1);
		$post_row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($post_row !== false)
		{
			$post_id = (int) $post_row['post_id'];
			$post_approved = $post_row['post_visibility'] == ITEM_APPROVED;
		}

		return $post_row !== false;
	}

	/**
	 * Check if the user has already introduced himself, in whichever mode (forum or topic) is
	 * currently configured. This is the mode-agnostic entry point that all callers should use
	 * instead of calling is_user_post_into_forum() / is_user_post_into_topic() directly.
	 *
	 * @param int		$user_id		User's ID
	 * @param int		$topic_id		If this function returns true, contains the topic ID of the introduction
	 * @param int		$post_id		If this function returns true, contains the post ID of the introduction
	 * @param boolean	$approved		If this function returns true, contains true / false if the introduction is approved or not
	 *
	 * @return boolean
	 * @access public
	 */
	public function has_user_introduced($user_id, &$topic_id, &$post_id, &$approved)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if ((int) $this->introduciator_params['mode'] === self::MODE_TOPIC)
		{
			$topic_id = (int) $this->introduciator_params['fk_topic_id'];

			return $this->is_user_post_into_topic($topic_id, $user_id, $post_id, $approved);
		}

		return $this->is_user_post_into_forum((int) $this->introduciator_params['fk_forum_id'], $user_id, $topic_id, $post_id, $approved);
	}

	/**
	 * Check whether moving the given topics into the introduce forum (forum mode only) would create
	 * a duplicate: another, different topic already exists there, created by the same user as one of
	 * the topics about to be moved.
	 *
	 * No-op (returns an empty array) outside forum mode, when the destination isn't the introduce
	 * forum, when the extension or this specific check is disabled, or when there's nothing to check.
	 *
	 * @param array $topic_ids   Topic identifiers about to be moved
	 * @param int   $to_forum_id Destination forum identifier
	 *
	 * @return array Empty if no conflict; else one entry per conflict with 'moved_topic_id',
	 *               'moved_topic_title', 'poster_id', 'poster_name', 'poster_colour',
	 *               'existing_topic_id', 'existing_first_post_id'
	 * @access public
	 */
	public function check_move_creates_duplicate_introduction($topic_ids, $to_forum_id)
	{
		$conflicts = [];

		if (empty($topic_ids))
		{
			return $conflicts;
		}

		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if (!$this->is_introduciator_allowed()
			|| !$this->introduciator_params['is_check_move_duplicate']
			|| (int) $this->introduciator_params['mode'] !== self::MODE_FORUM
			|| (int) $this->introduciator_params['fk_forum_id'] !== (int) $to_forum_id)
		{
			return $conflicts;
		}

		$sql = 'SELECT t.topic_id, t.topic_title, t.topic_poster, u.username, u.user_colour
				FROM ' . TOPICS_TABLE . ' t
				LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t.topic_poster
				WHERE ' . $this->db->sql_in_set('t.topic_id', array_map('intval', $topic_ids));
		$result = $this->db->sql_query($sql);

		$moved = [];
		$poster_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$moved[] = $row;
			$poster_ids[] = (int) $row['topic_poster'];
		}
		$this->db->sql_freeresult($result);

		if (empty($moved))
		{
			return $conflicts;
		}

		// Every presentation those posters already have in the destination forum, in one query
		// rather than one per moved topic. Keyed by poster, holding every topic rather than just
		// the first, so a poster whose only match is the topic being moved is still compared
		// against their other presentations.
		$existing_by_poster = [];
		$sql = 'SELECT topic_id, topic_first_post_id, topic_poster
				FROM ' . TOPICS_TABLE . '
				WHERE ' . $this->db->sql_in_set('topic_poster', array_unique($poster_ids)) . '
				 AND topic_type = ' . POST_NORMAL . '
				 AND forum_id = ' . (int) $to_forum_id . '
				 AND topic_visibility <> ' . ITEM_DELETED . '
				 AND topic_first_post_id <> 0
				ORDER BY topic_id';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$existing_by_poster[(int) $row['topic_poster']][] = $row;
		}
		$this->db->sql_freeresult($result);

		foreach ($moved as $row)
		{
			$poster_id = (int) $row['topic_poster'];

			if (!isset($existing_by_poster[$poster_id]))
			{
				continue;
			}

			foreach ($existing_by_poster[$poster_id] as $existing)
			{
				if ((int) $existing['topic_id'] === (int) $row['topic_id'])
				{
					// The topic being moved is already there: not a duplicate of itself.
					continue;
				}

				$conflicts[] = [
					'moved_topic_id'			=> (int) $row['topic_id'],
					'moved_topic_title'			=> $row['topic_title'],
					'poster_id'					=> $poster_id,
					'poster_name'				=> $row['username'],
					'poster_colour'				=> $row['user_colour'],
					'existing_topic_id'			=> (int) $existing['topic_id'],
					'existing_first_post_id'	=> (int) $existing['topic_first_post_id'],
				];

				break;
			}
		}

		return $conflicts;
	}

	/**
	 * Check whether the given forum / topic IS the configured introduction scope: the forum, in
	 * forum mode, or the single shared topic, in topic mode.
	 *
	 * @param int $forum_id Forum identifier to test
	 * @param int $topic_id Topic identifier to test
	 *
	 * @return boolean
	 * @access public
	 */
	public function is_introduction_scope($forum_id, $topic_id)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if ((int) $this->introduciator_params['mode'] === self::MODE_TOPIC)
		{
			return (int) $topic_id === (int) $this->introduciator_params['fk_topic_id'];
		}

		return (int) $forum_id === (int) $this->introduciator_params['fk_forum_id'];
	}

	/**
	 * Check whether this specific posting action IS the act of introducing oneself: creating the
	 * topic, in forum mode, or replying / quoting into the shared topic, in topic mode.
	 *
	 * @param string	$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
	 * @param int		$forum_id	Forum identifier where the user try to post
	 * @param int		$topic_id	Topic identifier where the user try to post
	 *
	 * @return boolean
	 * @access public
	 */
	public function is_introduction_action($mode, $forum_id, $topic_id)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if ((int) $this->introduciator_params['mode'] === self::MODE_TOPIC)
		{
			return in_array($mode, ['reply', 'quote']) && (int) $topic_id === (int) $this->introduciator_params['fk_topic_id'];
		}

		return $mode == 'post' && (int) $forum_id === (int) $this->introduciator_params['fk_forum_id'];
	}

	/**
	 * Build the URL of the introduction scope itself: the forum, in forum mode, or the shared
	 * topic, in topic mode. Used for redirections and "return to" links.
	 *
	 * @return string
	 * @access public
	 */
	public function get_introduction_url()
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if ((int) $this->introduciator_params['mode'] === self::MODE_TOPIC)
		{
			return append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $this->introduciator_params['fk_forum_id'] . '&amp;t=' . (int) $this->introduciator_params['fk_topic_id']);
		}

		return append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $this->introduciator_params['fk_forum_id']);
	}

	/**
	 * Get the title to pre-fill (not enforce) when a member starts a new introduction topic, in
	 * the current user's language, with %username% substituted.
	 *
	 * Forum mode only: topic mode has no "new introduction topic" moment to pre-fill a title for.
	 *
	 * @param int $forum_id Forum the user is posting into
	 *
	 * @return string Empty if not applicable, or no template configured for this language
	 * @access public
	 */
	public function get_topic_title_template($forum_id)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if (!$this->is_introduciator_allowed()
			|| (int) $this->introduciator_params['mode'] !== self::MODE_FORUM
			|| (int) $this->introduciator_params['fk_forum_id'] !== (int) $forum_id)
		{
			return '';
		}

		foreach ($this->introduciator_get_explanations(false, true) as $explanation_value)
		{
			$title = $explanation_value['explanation']['topic_title_template'];

			if ($title !== '')
			{
				$this->replace_all_by([&$title], ['%username%' => $this->user->data['username']]);
			}

			return $title;
		}

		return '';
	}

	/**
	 * Get the directory used to store posting claim files.
	 *
	 * Creates it if missing.
	 *
	 * @return string Absolute path, without trailing slash.
	 * @access public
	 */
	public function get_claim_dir()
	{
		$dir = rtrim($this->root_path, '/') . '/' . self::CLAIM_DIR;

		if (!is_dir($dir))
		{
			@mkdir($dir, 0777, true);
		}

		return $dir;
	}

	/**
	 * Check whether the posting claim directory can actually be written to.
	 *
	 * Used to warn the admin in the ACP if the protection against duplicate
	 * introductions is silently disabled because of filesystem permissions.
	 *
	 * @return boolean
	 * @access public
	 */
	public function is_claim_storage_writable()
	{
		$dir = $this->get_claim_dir();

		return is_dir($dir) && is_writable($dir);
	}

	/**
	 * Try to atomically claim the "posting a new introduction" slot for a user.
	 *
	 * Uses fopen(..., 'x') to create the claim file only if it does not already
	 * exist: this is an atomic create-or-fail at the filesystem level, so two
	 * concurrent requests for the same user cannot both succeed. This is what
	 * closes the race that let a user create more than one introduction topic
	 * (double click, slow network resubmit, two tabs, back button + resubmit).
	 *
	 * If the claim directory is not writable, the claim is considered acquired
	 * (fail open): the protection is silently unavailable, but the admin is
	 * warned about it in the ACP via is_claim_storage_writable(), and it is
	 * preferable to a board where nobody can introduce themselves at all.
	 *
	 * @param int $user_id User identifier into database
	 *
	 * @return boolean True if the slot was claimed (or storage is unusable), false if
	 *                  another request already holds a claim for this user.
	 * @access protected
	 */
	protected function claim_introduction_slot($user_id)
	{
		$file = $this->get_claim_dir() . '/claim_' . (int) $user_id;

		// Release claims abandoned by a request that died before releasing them.
		if (file_exists($file) && filemtime($file) < time() - self::CLAIM_TIMEOUT)
		{
			@unlink($file);
		}

		$fp = @fopen($file, 'x');

		if ($fp === false)
		{
			// If the file still exists, another request genuinely holds the claim: deny.
			// If it does not exist, we simply could not write (permissions): fail open.
			return !file_exists($file);
		}

		fclose($fp);
		$this->posting_claim_file = $file;

		return true;
	}

	/**
	 * Release the posting claim held by this request, if any.
	 *
	 * Safe to call even when no claim is held.
	 *
	 * @return void
	 * @access public
	 */
	public function release_introduction_slot()
	{
		if ($this->posting_claim_file !== '')
		{
			@unlink($this->posting_claim_file);
			$this->posting_claim_file = '';
		}
	}

	/**
	 * Test if one of the user's groups has been selected into configuration.
	 *
	 * These groups are selected into ACP, recorded into INTRODUCIATOR_GROUPS_TABLE table.
	 * Call group_memberships function into includes/functions_user.php file.
	 *
	 * Return true if one of the user's group has been selected into configuration, false else.
	 *
	 * @param int $user_id User identifier into database
	 *
	 * @return boolean
	 * @access protected
	 */
	protected function is_user_in_groups_selected($user_id)
	{
		if (!function_exists('group_memberships'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		return group_memberships($this->get_selected_group_ids(), (int) $user_id, true);
	}

	/**
	 * Batch version of is_user_in_groups_selected(), for pages checking many users at once.
	 *
	 * Semantics are deliberately identical to the per-user call, including the phpBB quirk that
	 * an empty group selection matches any user who belongs to any group at all.
	 *
	 * @param array $user_ids List of user ids to test
	 *
	 * @return array Map of user id => true, holding only the users in a selected group
	 * @access protected
	 */
	protected function get_users_in_selected_groups(array $user_ids)
	{
		if (empty($user_ids))
		{
			return [];
		}

		if (!function_exists('group_memberships'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		$memberships = group_memberships($this->get_selected_group_ids(), $user_ids, false);

		$in_group = [];
		foreach ($memberships ?: [] as $membership)
		{
			$in_group[(int) $membership['user_id']] = true;
		}

		return $in_group;
	}

	/**
	 * Check if the user is ignored or must introduce himself.
	 *
	 * Check if it contains include groups or if doesn't contains exclude group.
	 * Check if it doesn't contains name of ignored username list.
	 *
	 * Return true if the user is ignored, false else.
	 *
	 * @param int		$poster_id		User's ID
	 * @param string	$poster_name	User's name
	 *
	 * @return boolean
	 * @access protected
	 */
	protected function is_user_ignored($poster_id, $poster_name)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		// Check if :
		//	1 : Include group is ON and the user is member of at least one group of the selected groups (include groups)
		//	2 : Include group is OFF (exclude) and the user is not member of one group of the selected groups (exclude groups)
		$is_in_group_selected = $this->is_user_in_groups_selected($poster_id);
		$user_ignored = true;

		// User is in selected group or out of selected group ?
		if (($this->introduciator_params['is_include_groups'] && $is_in_group_selected) || (!$this->introduciator_params['is_include_groups'] && !$is_in_group_selected))
		{
			$user_ignored = in_array(utf8_strtolower($poster_name), $this->get_ignored_users_list(), true);
		}

		return $user_ignored;
	}

	/**
	 * Split the configured ignored-users list into lowercased usernames.
	 *
	 * The list comes from a textarea, so entries can be separated by LF or CRLF and can carry
	 * stray spaces; both would otherwise make an entry silently never match. Empty lines are
	 * dropped so that a trailing newline does not ignore the anonymous user.
	 *
	 * @return array List of lowercased usernames to ignore
	 * @access public
	 */
	public function get_ignored_users_list()
	{
		$list = utf8_strtolower((string) $this->config['introduciator_ignored_users']);

		// A list saved by an older release can hold a byte-truncated character, which makes a
		// UTF-8 mode split fail outright, so fall back to a plain newline split.
		$entries = preg_split('/\R/u', $list);

		if ($entries === false)
		{
			$entries = explode("\n", str_replace("\r\n", "\n", $list));
		}

		$ignored = [];
		foreach ($entries as $entry)
		{
			$entry = trim($entry);
			if ($entry !== '')
			{
				$ignored[] = $entry;
			}
		}

		return $ignored;
	}

	/**
	 * Check if the user is ignored or must introduce himself.
	 *
	 * Check if it contains include groups or if doesn't contains exclude group.
	 * Check if it doesn't contains name of ignored username list.
	 * Be careful: the option 'is_introduction_mandatory' is not taken into account.
	 *
	 * Return true if the user must introduce himself pending of rights, false else.
	 *
	 * @param int					$poster_id			User's ID
	 * @param \phpbb\auth\auth		$authorisations		User's authorisations. It can be null if the we check authorisation from another user than the current one.
	 * @param string				$poster_name		User's name
	 *
	 * @return boolean
	 * @access public
	 */
	public function is_user_must_introduce_himself($poster_id, $authorisations, $poster_name)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		if ($this->introduciator_params['is_use_permissions'])
		{
			if ($authorisations === null)
			{
				$sql = 'SELECT user_id, username, user_permissions, user_type
						FROM ' . USERS_TABLE . '
						WHERE user_id = ' . (int) $poster_id;
				$result = $this->db->sql_query($sql);
				$userdata = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				if (!$userdata)
				{
					$this->user->setup('posting'); // Mandatory here else all forum is not in same language as user's one
					trigger_error('NO_USERS', E_USER_ERROR);
				}

				$authorisations = new \phpbb\auth\auth();
				$authorisations->acl($userdata);
			}

			$ret = $authorisations->acl_get('u_must_introduce');
		}
		else
		{
			$ret = !$this->is_user_ignored($poster_id, $poster_name);
		}

		return $ret;
	}

	/**
	 * Batch version of is_user_must_introduce_himself(), for pages that need to check many
	 * users at once (like the statistics page) without running one query per user.
	 *
	 * @param array	$users	List of rows, each containing at least 'topic_poster' (user id)
	 *						and 'topic_first_poster_name' (username).
	 *
	 * @return array List of topic_poster ids (int) among $users that must introduce themselves.
	 * @access public
	 */
	public function filter_users_that_must_introduce(array $users)
	{
		if (empty($this->introduciator_params))
		{
			$this->introduciator_params = $this->introduciator_getparams();
		}

		$filtered_ids = [];

		if ($this->introduciator_params['is_use_permissions'])
		{
			$poster_ids = array_unique(array_map(function ($user) {
				return (int) $user['topic_poster'];
			}, $users));

			$authorisations_by_id = [];
			if (!empty($poster_ids))
			{
				$sql = 'SELECT user_id, username, user_permissions, user_type
						FROM ' . USERS_TABLE . '
						WHERE ' . $this->db->sql_in_set('user_id', $poster_ids);
				$result = $this->db->sql_query($sql);
				while ($userdata = $this->db->sql_fetchrow($result))
				{
					$authorisations = new \phpbb\auth\auth();
					$authorisations->acl($userdata);
					$authorisations_by_id[(int) $userdata['user_id']] = $authorisations;
				}
				$this->db->sql_freeresult($result);
			}

			foreach ($users as $user)
			{
				$poster_id = (int) $user['topic_poster'];

				// A poster_id with no matching row (eg. deleted user) is skipped rather than
				// treated as an error: this is a report, not a single-user posting check.
				if (isset($authorisations_by_id[$poster_id]) && $authorisations_by_id[$poster_id]->acl_get('u_must_introduce'))
				{
					$filtered_ids[] = $poster_id;
				}
			}
		}
		else
		{
			$poster_ids = array_unique(array_map(function ($user) {
				return (int) $user['topic_poster'];
			}, $users));

			// One membership query for every user on the page instead of one per user. The set
			// of ids that come back is exactly the set for which the per-user check would have
			// answered "in a selected group", empty selection included.
			$in_selected_group = $this->get_users_in_selected_groups($poster_ids);
			$ignored_users = $this->get_ignored_users_list();

			foreach ($users as $user)
			{
				$poster_id = (int) $user['topic_poster'];
				$is_in_group_selected = isset($in_selected_group[$poster_id]);

				if (($this->introduciator_params['is_include_groups'] && $is_in_group_selected) || (!$this->introduciator_params['is_include_groups'] && !$is_in_group_selected))
				{
					if (!in_array(utf8_strtolower($user['topic_first_poster_name']), $ignored_users, true))
					{
						$filtered_ids[] = $poster_id;
					}
				}
			}
		}

		return $filtered_ids;
	}

	/**
	 * Get the approval level for the post using introduciator configuration.
	 *
	 * Return the approval level for this post, depending of extension configuration.
	 *
	 * @param string		$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc
	 * @param int			$forum_id	Forum identifier where the user try to post
	 * @param int			$topic_id	Topic identifier where the user try to post, 0 if not applicable
	 *
	 * @return int
	 * @access public
	 */
	public function get_post_approval_level($mode, $forum_id, $topic_id = 0)
	{
		$poster_id = (int) $this->user->data['user_id'];
		$ret_posting_approval_level = $this::APPROVAL_LEVEL_NO_APPROVAL;

		// User is logged and have user authorization
		if ($poster_id != ANONYMOUS && $this->is_introduciator_allowed())
		{
			// Extension is enabled and the user is not ignored, it can do all he wants
			// Force forum id because it be moved while user delete the message
			if (empty($this->introduciator_params))
			{
				$this->introduciator_params = $this->introduciator_getparams();
			}

			if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
			{
				$introduce_topic_id = 0;
				$introduce_post_id = 0;
				$post_approved = false;

				if (!$this->has_user_introduced($poster_id, $introduce_topic_id, $introduce_post_id, $post_approved) && $this->is_introduction_action($mode, $forum_id, $topic_id) && ($this->introduciator_params['posting_approval_level'] == $this::APPROVAL_LEVEL_APPROVAL || $this->introduciator_params['posting_approval_level'] == $this::APPROVAL_LEVEL_APPROVAL_WITH_EDIT))
				{
					// No post into the introduce topic yet: this action is the (single) one that
					// goes through approval — any further post in the same scope will not.
					$ret_posting_approval_level = $this->introduciator_params['posting_approval_level'];
				}
			}
		}

		return $ret_posting_approval_level;
	}

	/**
	 * Get the approval level for the post using introduciator configuration.
	 *
	 * Return true if the sql visibility must be overwrite, false else.
	 *
	 * @param int			$forum_id						Forum identifier where the user try to post
	 * @param string		$where_sql						Current SQL WHERE used, must be concatenate with it.
	 * @param string		$mode							Topic or post.
	 * @param string		$table_alias alias				Table's name to use.
	 * @param string		$get_visibility_sql_overwrite	Contains the SQL to send to get correct topic visibility if the function returns true.
	 *
	 * @return boolean
	 * @access public
	 */
	public function get_topic_sql_visibility($forum_id, $where_sql, $mode, $table_alias, &$get_visibility_sql_overwrite)
	{
		$poster_id = (int) $this->user->data['user_id'];
		$ret = false;

		if ($poster_id != ANONYMOUS && !$this->auth->acl_get('m_approve', $forum_id))
		{
			// User is logged and have user authorization
			// If the user has m_approve right, nothing to do, he will see the topic
			if ($this->is_introduciator_allowed())
			{
				// Extension is enabled
				if (empty($this->introduciator_params))
				{
					$this->introduciator_params = $this->introduciator_getparams();
				}

				if ($forum_id == (int) $this->introduciator_params['fk_forum_id'] && $this->introduciator_params['posting_approval_level'] == $this::APPROVAL_LEVEL_APPROVAL_WITH_EDIT && $this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					// It is the forum with approval level + edit and user should introduce himself
					$topic_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if ($this->has_user_introduced($poster_id, $topic_id, $first_post_id, $topic_approved))
					{
						// Is is the introduce forum and he post into it
						if (!$topic_approved)
						{
							// The topic is waiting approval: the user is allowed to see and modify it's own message into this mode
							$ret = true;
							$get_visibility_sql_overwrite = $where_sql . '(' . $table_alias . $mode . '_visibility = ' . ITEM_APPROVED . ' OR ' . $table_alias . 'topic_id = ' . $topic_id . ')';
						}
					}
				}
			}
		}

		return $ret;
	}

	/**
	 * Get the approval level for the post using introduciator configuration.
	 *
	 * Return true if the user is allowed to make action,
	 *        false else, in this case, just check if allowed or not (remove quick reply if not allowed).
	 *
	 * @param string		$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
	 * @param int			$forum_id	Forum identifier.
	 * @param int			$topic_id	Topic identifier, 0 if not applicable.
	 * @param array			$post_data	Informations about posting.
	 *
	 * @return boolean
	 * @access public
	 */
	public function user_can_post_or_edit($mode, $forum_id, $topic_id, $post_data)
	{
		return $this->user_can_post($mode, $forum_id, 0, $post_data, true, false, $topic_id);
	}
}
