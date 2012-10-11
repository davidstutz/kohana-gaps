<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Text driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Text extends Kohana_Gaps_Driver

{
	/**
	 * @var used view
	 */
	protected $_view = 'text';

	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param	array 	post
	 */
	public function load($model, $post)
	{
		$model->{$this->_field} = $post[$this->_field];
	}
}
