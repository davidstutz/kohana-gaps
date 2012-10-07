<?php defined('SYSPATH') or die('No direct access allowed.');

/**
* Gaps module configuration.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://www.gnu.org/licenses/gpl-3.0
*/
return array(
		/**
		 * Prefix for CSS classes used e.g. for "input", "field" etc.
		 * Note: Not supported for all themes.
		 */
		'prefix' => 'planer-gaps-',
		
		/**
		 * Class used for error div.
		 */
		'error' => '<div>
						<p>' . __('See error(s) below') . '</p>
						<p>:errors</p>
					</div>',
					
		/**
		 * Theme used for views.
		 */
		'theme' => 'default',
);
