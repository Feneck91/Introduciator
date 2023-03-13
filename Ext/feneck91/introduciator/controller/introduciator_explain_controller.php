<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @author Feneck91 (Stéphane Château) feneck91@free.fr
 * @copyright (c) 2019-2022 Feneck91
 * @copyright (c) 2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace feneck91\introduciator\controller;

use feneck91\introduciator\helper\introduciator_helper;
use phpbb\controller\helper;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;

/**
 * Class used to display introduciator explanation page.
 *
 * This page is displayed when user try to post and have not yet written it's introduce.
 * It explain that the introduce is mandatory and display links to help user to begin it's introduce.
 */
class introduciator_explain_controller
{
	/**
	 * @var introduciator_helper Introduciator helper. The important code is into this helper.
	 */
	protected $introduciator_helper;

	/**
	  *  @var \phpbb\controller\helper phpBB helper.
	  */
	protected $helper;

	/**
	 * @var \phpbb\config\config Current configuration (config table).
	 */
	protected $config;

	/**
	 * @var \phpbb\template\template Template object
	 */
	protected $template;

	/**
	 * @var \phpbb\user Current connected user.
	 */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param introduciator_helper          $introduciator_helper    Extension helper
	 * @param \phpbb\controller\helper      $helper                  phpBB helper
	 * @param \phpbb\config\config          $config                  Current configuration (config table)
	 * @param \phpbb\template\template      $template                Template object
	 * @param \phpbb\user                   $user                    User object
	 *
	 * @access public
	 */
	public function __construct(introduciator_helper $introduciator_helper, helper $helper, config $config, template $template, user $user)
	{
		$this->introduciator_helper = $introduciator_helper;
		$this->helper = $helper;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	 * Handle events.
	 *
	 * Called when explain page is displayed to the user.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response object containing rendered page.
	 * @access public
	 */
	public function handle()
	{
		if ($this->introduciator_helper->is_introduciator_allowed())
		{	// Title message
			$this->introduciator_helper->load_language();

			// If user not connected, go to login page
			if ($this->user->data['user_id'] == ANONYMOUS)
			{
				// In case of introduciator_getparams is not called, I must load the introduciator language file
				login_box('', $this->introduciator_helper->get_language()->lang('LOGIN'));
			}

			// Load extension configuration + language
			$params = $this->introduciator_helper->introduciator_getparams(false);
			$message = $this->introduciator_helper->get_language()->lang('INTRODUCIATOR_EXT_MUST_INTRODUCE_INTO_FORUM', $params['forum_name']);

			$this->template->assign_vars(array(
				'S_EXT_ACTIVATED'					=> true,
				'INTRODUCIATOR_EXT_EXPLAIN_TITLE'	=> $params['explanation_message_title'],
				'INTRODUCIATOR_EXT_EXPLAIN_TEXT'	=> $params['explanation_message_text'],
				'S_RULES_ACTIVATED'					=> $params['is_explanation_display_rules'] && $params['explanation_rules_text'] != '',
				'S_RULES_TITLE_ACTIVATED'			=> $params['explanation_rules_title'] != '',
				'INTRODUCIATOR_EXT_RULES_TITLE'		=> $params['explanation_rules_title'],
				'INTRODUCIATOR_EXT_RULES_TEXT'		=> $params['explanation_rules_text'],
				'INTRODUCIATOR_EXT_LINK_GOTO_FORUM'	=> $params['explanation_message_goto_forum'],
				'INTRODUCIATOR_EXT_LINK_POST_FORUM'	=> $params['explanation_message_post_forum'],
				'INTRODUCIATOR_EXT_LINK_FORUM_URL'	=> $params['forum_url'],
				'INTRODUCIATOR_EXT_LINK_FORUM_POST'	=> $params['forum_post'],
				));
		}
		else
		{
			$message = '';
			$this->template->assign_vars(array(
				'S_EXT_ACTIVATED'					=> false,
				));
		}

		return $this->helper->render('introduciator_explain.html', $message);
	}
}
