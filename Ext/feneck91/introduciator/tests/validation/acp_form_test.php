<?php
/**
 *
 * @package phpBB Extension - Introduciator Extension
 * @copyright (c) 2019-2026 Feneck91
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

namespace feneck91\introduciator\tests\validation;

class acp_form_test extends \phpbb_test_case
{
	/**
	 * Names phpBB itself reads out of the ACP request to decide which module and mode to run
	 * (see adm/index.php and p_master::set_active()). A form field sharing one of these silently
	 * hijacks routing, because $request->variable() resolves REQUEST as POST + GET: the posted
	 * value wins over the one in the form's action URL, the module lookup finds no match, and
	 * phpBB falls back to the first module in the category without ever running the controller.
	 */
	private const RESERVED_ACP_PARAMETERS = ['i', 'icat', 'mode', 'sid'];

	public function test_acp_form_fields_do_not_shadow_phpbb_request_parameters()
	{
		foreach (glob(dirname(__DIR__, 2) . '/adm/style/*.html') as $template)
		{
			preg_match_all('/\bname="([^"]+)"/', file_get_contents($template), $matches);

			foreach (array_unique($matches[1]) as $field)
			{
				$field = rtrim($field, '[]');

				$this->assertNotContains(
					$field,
					self::RESERVED_ACP_PARAMETERS,
					basename($template) . ' posts a field named "' . $field . '", which phpBB reads as an ACP routing parameter.'
				);
			}
		}
	}

	public function test_every_acp_form_carries_the_csrf_token()
	{
		foreach (glob(dirname(__DIR__, 2) . '/adm/style/*.html') as $template)
		{
			$content = file_get_contents($template);

			if (strpos($content, '<form') === false)
			{
				continue;
			}

			$this->assertStringContainsString(
				'{S_FORM_TOKEN}',
				$content,
				basename($template) . ' has a form but never emits the form key.'
			);
		}
	}
}
