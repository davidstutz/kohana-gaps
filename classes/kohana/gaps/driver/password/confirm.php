<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Password confirm driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Password_Confirm extends Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used view
	 */
	protected $_view = 'password/confirm';

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
