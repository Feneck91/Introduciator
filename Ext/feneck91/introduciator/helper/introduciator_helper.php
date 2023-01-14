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
	const INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL          = 0; // No approval introduce
	const INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL             = 1; // Approval introduce : the user don't see his introduce and cannot edit it
	const INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT   = 2; // Approval introduce : the user see his introduce and can edit it

	/**
	 * @var string Table prefix.
	 */
	private $table_prefix;

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
	 * Constructor
	 *
	 * @param string					$table_prefix Table prefix.
	 * @param string					$root_path phpBB root path.
	 * @param string					$php_ext phpBB Extension.
	 * @param \phpbb\user				$user Current connected user.
	 * @param \phpbb\db\driver\factory	$db Database access.
	 * @param \phpbb\config\config 		$config Current configuration (config table).
	 * @param \phpbb\auth\auth 			$auth Current authorizations.
	 * @param \phpbb\controller\helper  $controller_helper Controller helper, used to generate route.
	 * @param \phpbb\language\language  $language Language manager, used to translate all messages.
	 */
	public function __construct($table_prefix, $root_path, $php_ext, \phpbb\user $user, \phpbb\db\driver\factory $db, \phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\controller\helper $controller_helper, \phpbb\language\language $language)
	{
		// Record parameters into this
		$this->table_prefix = $table_prefix;
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
	public function load_language_if_needed()
	{
		if (!$this->language_loaded)
		{
			$this->language->add_lang('introduciator', 'feneck91/introduciator');	// Add lang
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
	 * Get the introduciator groups table name (with prefix).
	 *
	 * It's not possible to create const INTRODUCIATOR_GROUPS_TABLE because it need table prefix.
	 * So, I use a method to get this name.
	 *
	 * Return the full group table name.
	 *
	 * @return string
	 * @access public
	 */
	public function get_introduciator_groups_table()
	{
		return $this->table_prefix . 'introduciator_groups';
	}

	/**
	 * Get the introduciator groups table name (with prefix).
	 *
	 * It's not possible to create const INTRODUCIATOR_EXPLANATION_TABLE because it need table prefix.
	 * So, I use a method to get this name.
	 *
	 * Return the full explanation table name.
	 *
	 * @return string
	 * @access public
	 */
	public function get_introduciator_explanation_table()
	{
		return $this->table_prefix . 'introduciator_explanation';
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
		return $this->config['introduciator_allow'] != '0';
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
	public function get_url_to_post($forum_id, $topic_id, $post_id)
	{
		return append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $forum_id .'&amp;t=' . (int) $topic_id . '#p' . (int) $post_id);
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
		$sql = 'SELECT COUNT(*) AS cnt
				FROM ' . $this->get_introduciator_groups_table() . '
				WHERE fk_group = ' . (int) $group_id;

		$result = $this->db->sql_query($sql);
		$ret = (int) $this->db->sql_fetchfield('cnt') > 0;
		$this->db->sql_freeresult($result);

		return $ret;
	}

	/**
	 * Replace all variables with several values.
	 *
	 * Example :
	 * 	replace_all_by(
	 *		array(
	 *			&$var_1,
	 *			&$var_2
	 *			),
	 *		array(
	 *			'search1'	=> 'replaced by this text1',
	 *			'search2'	=> 'replaced by this text2',
	 *			'search3'	=> 'replaced by this text3',
	 *			));
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
	 * Get the explanations informations.
	 *
	 * Return an array of explanation text used to edit or display.
	 *
	 * @param boolean $is_edit if true, return rules texts for editing
	 *                         else return rules texts for display
	 * @param boolean $only_current_lang if true, return only user's default language.
	 *                                    else return alls languages (used only in the extension configuration and to display all rules in all languages)
	 *
	 * @return array
	 * @access public
	 */
	public function introduciator_get_explanations($is_edit = null, $only_current_lang = null)
	{
		$arr_request = array(
			'SELECT'    => 'l.lang_iso, l.lang_local_name, e.*',
			'FROM'      => array(LANG_TABLE => 'l'),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($this->get_introduciator_explanation_table() => 'e'),
					'ON'	=> 'e.lang = l.lang_iso'
				)
			),
			'ORDER BY'	=> 'l.lang_id',
		);

		if ($only_current_lang === true)
		{
			// Add WHERE to get only the current user language
			$arr_request = array_merge($arr_request, array(
					'WHERE'		=> "l.lang_iso = '{$this->db->sql_escape($this->user->lang_name)}'",
				)
			);
		}

		$sql = $this->db->sql_build_query('SELECT', $arr_request);
		$ret_value = array();
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

			if ($is_edit === true)
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
					array(
						&$message_title,
						&$message_text,
						&$rules_title,
						&$rules_text,
					),
					array(
						'http&#58;//aghxkfps&#46;com'	=> '%forum_url%',
						'http&#58;//dqsdfzef&#46;com'	=> '%forum_post%',
					));

				$ret_value[] = array(
					'lang_local_name'		=>	$row['lang_local_name'],
					'lang_iso'				=> 	$row['lang_iso'],
					'explanation'			=> array(
						'edit_message_title'	=> $message_title,
						'edit_message_text'		=> $message_text,
						'edit_rules_title'		=> $rules_title,
						'edit_rules_text'		=> $rules_text,
					),
				);
			}
			else
			{
				$ret_value[] = array(
					'lang_local_name'		=>	$row['lang_local_name'],
					'lang_iso'				=> 	$row['lang_iso'],
					'explanation'			=> array(
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
					),
				);
			}
		}

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
		$params = array(
			'introduciator_allow'					=> $this->is_introduciator_allowed(),
			'fk_forum_id'							=> $this->config['introduciator_fk_forum_id'],
			'is_introduction_mandatory'				=> $this->config['introduciator_is_introduction_mandatory'],
			'is_check_delete_first_post'			=> $this->config['introduciator_is_check_delete_first_post'],
			'is_explanation_enabled'				=> $this->config['introduciator_is_explanation_enabled'],
			'is_use_permissions'					=> $this->config['introduciator_is_use_permissions'],
			'is_include_groups'						=> $this->config['introduciator_is_include_groups'],
			'ignored_users'							=> $this->config['introduciator_ignored_users'],
			'is_explanation_display_rules'			=> $this->config['introduciator_is_explanation_display_rules'],
			'posting_approval_level'				=> $this->config['introduciator_posting_approval_level'],
		);

		if ($is_edit === true || $is_edit === false)
		{
			$forum_name = '';
			$forum_rules = array();

			if ($params['introduciator_allow'])
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
					$forum_rules = array(
						'rules'				=> $row['forum_rules'],
						'rules_uid'			=> $row['forum_rules_uid'],
						'rules_bitfield'	=> $row['forum_rules_bitfield'],
						'rules_options'		=> $row['forum_rules_options'],
					);
				}
				$this->db->sql_freeresult($result);
			}

			if ($is_edit === true)
			{
				$params = array_merge($params, array(
					'explanations' => $this->introduciator_get_explanations(true, false),
				));
			}
			else
			{
				// Load langage
				$this->load_language_if_needed();

				// Only one into explanation (the user default language)
				foreach ($this->introduciator_get_explanations($is_edit, true) as $explanation_value)
				{
					$explanation = $explanation_value['explanation'];
					$forum_url = append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $params['fk_forum_id']);
					$forum_post = append_sid("{$this->root_path}posting.{$this->php_ext}", 'mode=post&amp;f=' . (int) $params['fk_forum_id']);
					// Generate all string to be displayed
					$explanation_message_title = generate_text_for_display($explanation['message_title'], $explanation['message_title_uid'], $explanation['message_title_bitfield'], $explanation['message_title_bbcode_options']);
					$explanation_message_text = generate_text_for_display($explanation['message_text'], $explanation['message_text_uid'], $explanation['message_text_bitfield'], $explanation['message_text_bbcode_options']);
					$explanation_rules_title = generate_text_for_display($explanation['rules_title'], $explanation['rules_title_uid'], $explanation['rules_title_bitfield'], $explanation['rules_title_bbcode_options']);
					$explanation_rules_text = generate_text_for_display($explanation['rules_text'], $explanation['rules_text_uid'], $explanation['rules_text_bitfield'], $explanation['rules_text_bbcode_options']);
					$explanation_message_title = str_replace('%explanation_title%', $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TITLE'), $explanation_message_title);
					$explanation_message_text = str_replace('%explanation_text%', $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT', $forum_url, $forum_name) . (($params['is_explanation_display_rules'] && $explanation_message_text != '' && $explanation_rules_text != '') ? $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_MESSAGE_TEXT_RULES') : ''), $explanation_message_text);
					$explanation_rules_title = str_replace('%rules_title%', $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_RULES_TITLE'), $explanation_rules_title);
					$explanation_rules_text = str_replace('%rules_text%', generate_text_for_display($forum_rules['rules'], $forum_rules['rules_uid'], $forum_rules['rules_bitfield'], $forum_rules['rules_options']), $explanation_rules_text);
					$link_goto_forum = $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_LINK_GOTO_FORUM', $forum_name);
					$link_post_forum = $this->language->lang('INTRODUCIATOR_EXT_DEFAULT_LINK_POST_FORUM');

					// Replace in each string the predefined fields
					$this->replace_all_by(
						array(
							&$explanation_message_title,
							&$explanation_message_text,
							&$explanation_rules_title,
							&$explanation_rules_text,
						),
						array(
							'%forum_name%'			=> $forum_name,
							'http://aghxkfps.tld'	=> $forum_url,	// Restore correct link
							'http://dqsdfzef.tld'	=> $forum_post,	// Restore correct link
						)
					);

					// Make links into $link_goto_forum / $link_post_forum
					$this->replace_all_by(
						array(
							&$explanation_message_title,		// if text is from $this->language->lang(xx),
							&$explanation_message_text,
							&$explanation_rules_title,
							&$explanation_rules_text,
							&$link_goto_forum,
							&$link_post_forum,
						),
						array(
							'%forum_name%'	=> $forum_name,
							'%forum_url%'	=> $forum_url,
							'%forum_post%'	=> $forum_post,
						)
					);

					$params = array_merge($params, array(
						'explanation_message_title'				=> $explanation_message_title,
						'explanation_message_text'				=> $explanation_message_text,
						'explanation_rules_title'				=> $explanation_rules_title,
						'explanation_rules_text'				=> $explanation_rules_text,
						'explanation_message_goto_forum'		=> $link_goto_forum,
						'explanation_message_post_forum'		=> $link_post_forum,
						'forum_name'							=> $forum_name,
						'forum_url'								=> $forum_url,
						'forum_post'							=> $forum_post,
					));
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
	 *
	 * @return boolean
	 * @access public
	 */
	public function introduciator_verify_posting($mode, $forum_id, $post_id, $post_data, $redirect)
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
						$topic_id = (int) $row['topic_id'];
						$first_poster_id = (int) $row['poster_id'];	// <-- $poster_id could be <> from current user id
																	// It's this case when moderator try to delete post of another user

						if (!empty($topic_id) && !empty($first_poster_id))
						{
							// Check if this post is the first one, ie this is the post that created the Topic
							$topic_first_post_id = (int) $post_data['topic_first_post_id'];

							if (!empty($topic_first_post_id) && $topic_first_post_id == $post_id)
							{
								// Check if the topic contains more than one post: if contains only one post, keep default behavior
								$sql = 'SELECT count(1)
										FROM ' . POSTS_TABLE . '
										WHERE topic_id = ' . $topic_id . ' AND post_visibility <> ' . ITEM_DELETED;

								$result = $this->db->sql_query($sql);
								$row = $this->db->sql_fetchrow($result);
								$this->db->sql_freeresult($result);
								$posts_count = (int) $row['count(1)'];

								if ($posts_count > 1)
								{
									// The user try to delete the first post of one introduce topic : may be not allowed
									// Even the the $first_poster_id is ignored, no way to delete the first post of any introduction of any users
									// if the configuration option (authorize extension to verify the deletion of first post introduction) is selected
									$ret_allowed_action = false;
									if ($redirect)
									{
										// Load langage
										$this->user->setup("posting"); // Mandatory here else all forum is not in same language as user's one
										$this->load_language_if_needed();

										$message = $first_poster_id === $poster_id && !$this->auth->acl_get('m_delete', $forum_id) ? $this->language->lang('INTRODUCIATOR_EXT_DELETE_INTRODUCE_MY_FIRST_POST') : $this->language->lang('INTRODUCIATOR_EXT_DELETE_INTRODUCE_FIRST_POST');
										$meta_info = append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . (int) $forum_id . '&amp;t=' . (int) $topic_id);
										$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_TOPIC'), '<a href="' . $meta_info . '">', '</a>');
										$message .= '<br /><br />' . sprintf($this->language->lang('RETURN_FORUM'), '<a href="' . append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . (int) $forum_id) . '">', '</a>');
										trigger_error($message, E_USER_NOTICE);
									}
								}
							}
						}
					}
				}
				else if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					$topic_introduce_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if (!$this->is_user_post_into_forum((int) $this->introduciator_params['fk_forum_id'], $poster_id, $topic_introduce_id, $first_post_id, $topic_approved))
					{
						// No post into the introduce topic
						if ($this->introduciator_params['is_introduction_mandatory'] && (in_array($mode, array('reply', 'quote')) || ($mode == 'post' && $forum_id != $this->introduciator_params['fk_forum_id'])))
						{
							$ret_allowed_action = false;
							// Make these test ONLY if the introduction is mandatory (is_introduction_mandatory) else ignore all, the user post even he is not introduce
							if ($redirect)
							{
								if ($this->introduciator_params['is_explanation_enabled'])
								{
									redirect($this->controller_helper->route('feneck91_introduciator_explain', array('forum_id' => (int) $this->introduciator_params['fk_forum_id'])));
								}
								else
								{
									redirect(append_sid("{$this->root_path}viewforum.{$this->php_ext}",'f=' . (int) $this->introduciator_params['fk_forum_id']));
								}
							}
						}
					}
					else if (!$topic_approved && in_array($mode, array('reply', 'quote', 'post')))
					{
						// At least one post but not approved !
						if (($this->introduciator_params['is_introduction_mandatory'] || (!$this->introduciator_params['is_introduction_mandatory'] && $this->introduciator_params['fk_forum_id'] == $forum_id))
							&& (!in_array($mode, array('reply', 'quote')) || !$this->auth->acl_get('m_approve', $forum_id) || $this->introduciator_params['fk_forum_id'] != $forum_id || $this->introduciator_params['posting_approval_level'] != $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT))
						{
							// If is_introduction_mandatory is false the user can do what he wants in other forums that introduce one, else the rules are same (as is_introduction_mandatory = true).
							// Can quote / reply if the user is allowed to approval this introduction (moderator) -> Right of reply or quote is done by the framework,
							// here we just test if right are approve to don't show next message: here, the right are not correct => display the message
							$ret_allowed_action = false;
						}

						if (!$ret_allowed_action && $redirect)
						{
							// Load langage
							$this->user->setup("posting"); // Mandatory here else all forum is not in same language as user's one
							$this->load_language_if_needed();

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
					else if ($forum_id == $this->introduciator_params['fk_forum_id'] && $mode == 'post')
					{
						// User try to create more than one introduce post
						$ret_allowed_action = false;
						if ($redirect)
						{
							// Load langage
							$this->user->setup("posting"); // Mandatory here else all forum is not in same language as user's one
							$this->load_language_if_needed();

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
				$this->load_language_if_needed();

				if (!$this->is_user_post_into_forum((int) $this->introduciator_params['fk_forum_id'], (int) $poster_id, $topic_id, $first_post_id, $topic_approved))
				{
					// No post into the introduce topic
					$text = $this->language->lang('INTRODUCIATOR_TOPIC_VIEW_NO_PRESENTATION');
					$class = 'introdno-icon';
				}
				else if ($topic_approved)
				{
					$text = $this->language->lang('INTRODUCIATOR_TOPIC_VIEW_PRESENTATION');
					$url = $this->get_url_to_post($this->introduciator_params['fk_forum_id'], $topic_id, $first_post_id);
					$class = 'introd-icon';
				}
				else
				{
					$text = $this->language->lang('INTRODUCIATOR_TOPIC_VIEW_APPROBATION_PRESENTATION');
					$pending = true;
					if ($this->auth->acl_get('m_approve', $this->introduciator_params['fk_forum_id']) || ($this->introduciator_params['posting_approval_level'] == $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT && $poster_id == (int) $this->user->data['user_id']))
					{
						// Display url if user can approve the introduction of this user
						// or if the current user is the poster (the user can see its own presentation) AND the extension configuration is INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT
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

		return array(
			'display'		=> $display,
			'url'			=> $url,
			'text'			=> $text,
			'class'			=> $class,
			'pending'		=> $pending,
		);
	}

	/**
	 * Verify if the posting is must be approved or not.
	 *
	 * If the user that post have right to approved it's own presentation,
	 * the function return always false: no need to make manage approval to a user
	 * that can approve himself its own message.
	 *
	 * Return true if the post must be approved, false else.
	 *
	 * @param string			$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
	 * @param int				$forum_id	Forum identifier where the user try to post
	 *
	 * @return boolean
	 * @access public
	 */
	public function introduciator_is_posting_must_be_approved($mode, $forum_id)
	{
		return !$this->auth->acl_get('m_approve', $forum_id) && $this->introduciator_get_posting_approval_level($mode, $forum_id) != $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL;
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
	 * approval state (only for INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT configuration).
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

			if (($forum_id === null || $this->introduciator_params['fk_forum_id'] == $forum_id) && $this->introduciator_params['posting_approval_level'] == $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
			{
				$poster_id = (int) $this->user->data['user_id'];
				if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					$topic_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if ($this->is_user_post_into_forum($this->introduciator_params['fk_forum_id'], $poster_id, $topic_id, $first_post_id, $topic_approved) && !$topic_approved)
					{
						// Post into this introduce topic
						$sql_approved = $this->str_replace_once('AND (t.topic_visibility', 'AND ((t.topic_visibility', $sql_approved) . ' OR ' . (empty($table_name) ? '' : $table_name . '.') . 'topic_id = ' . (int) $topic_id . ')';
						if ($approve_fid_ary !== null)
						{
							$approve_fid_ary = array($topic_id);
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
	 * This function is used only for INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT level.
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

			if ($this->introduciator_params['fk_forum_id'] == $forum_id && $this->introduciator_params['posting_approval_level'] == $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT)
			{
				$poster_id = (int) $this->user->data['user_id'];
				if ($this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					$topic_introduce_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if ($this->is_user_post_into_forum($this->introduciator_params['fk_forum_id'], $poster_id, $topic_introduce_id, $first_post_id, $topic_approved) && !$topic_approved && $topic_id == $topic_introduce_id)
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
		$sql = 'SELECT topic_id, topic_first_post_id, topic_visibility
				FROM ' . TOPICS_TABLE . '
				WHERE topic_poster = ' . (int) $user_id . '
				 AND topic_type = ' . POST_NORMAL . '
				 AND forum_id = ' . (int) $forum_id . '
				 AND topic_visibility <> ' . ITEM_DELETED . '
				 AND topic_first_post_id <> 0'; // PATCH : Sometimes, the topic_first_post_id is 0

		$result = $this->db->sql_query($sql);
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
		$sql = 'SELECT *
				FROM ' . $this->get_introduciator_groups_table();
		$result = $this->db->sql_query($sql);

		// Construct an array of group ID present into INTRODUCIATOR_GROUPS_TABLE table
		$arr_groups_id = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			// Merge array
			array_push($arr_groups_id, $row['fk_group']);
		}
		$this->db->sql_freeresult($result);

		// Testing
		if (!function_exists('group_memberships'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}

		return group_memberships($arr_groups_id, (int) $user_id, true);
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
			$user_ignored = in_array(utf8_strtolower($poster_name), explode("\n", utf8_strtolower($this->introduciator_params['ignored_users'])));
		}

		return $user_ignored;
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
					$this->user->setup("posting"); // Mandatory here else all forum is not in same language as user's one
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
	 * Get the approval level for the post using introduciator configuration.
	 *
	 * Return the approval level for this post, depending of extension configuration.
	 *
	 * @param string		$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc
	 * @param int			$forum_id	Forum identifier where the user try to post
	 *
	 * @return int
	 * @access public
	 */
	public function introduciator_get_posting_approval_level($mode, $forum_id)
	{
		$poster_id = (int) $this->user->data['user_id'];
		$ret_posting_approval_level = $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_NO_APPROVAL;

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
				$topic_id = 0;
				$first_post_id = 0;
				$topic_approved = false;

				if (!$this->is_user_post_into_forum((int) $this->introduciator_params['fk_forum_id'], $poster_id, $topic_id, $first_post_id, $topic_approved) && $mode == 'post' && $forum_id == $this->introduciator_params['fk_forum_id'] && ($this->introduciator_params['posting_approval_level'] == $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL || $this->introduciator_params['posting_approval_level'] == $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT))
				{
					// No post into the introduce topic
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
			{	// Extension is enabled
				if (empty($this->introduciator_params))
				{
					$this->introduciator_params = $this->introduciator_getparams();
				}

				if ($forum_id == (int) $this->introduciator_params['fk_forum_id'] && $this->introduciator_params['posting_approval_level'] == $this::INTRODUCIATOR_POSTING_APPROVAL_LEVEL_APPROVAL_WITH_EDIT && $this->is_user_must_introduce_himself($poster_id, $this->auth, $this->user->data['username']))
				{
					// It is the forum with approval level + edit and user should introduce himself
					$topic_id = 0;
					$first_post_id = 0;
					$topic_approved = false;

					if ($this->is_user_post_into_forum((int) $forum_id, $poster_id, $topic_id, $first_post_id, $topic_approved))
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
	 * @param string			$mode		Posting mode, could be 'reply' or 'quote' or 'post' or 'delete', etc.
	 * @param array				$post_data	Informations about posting.
	 *
	 * @return boolean
	 * @access public
	 */
	public function introduciator_let_user_posting_or_editing($mode, $forum_id, $post_data)
	{
		return $this->introduciator_verify_posting($mode, $forum_id, 0, $post_data, true);
	}
}
