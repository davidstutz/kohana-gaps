<?php defined('SYSPATH') or die('No direct access allowed.');

/**
* Gaps module configuration.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
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
