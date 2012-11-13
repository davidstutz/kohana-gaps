<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Datetime driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Datetime extends Kohana_Gaps_Driver

{
	/**
	 * @var used view
	 */
	protected $_view = 'datetime';

	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param	array 	post
	 */
	public function load($model, $post)
	{
		$model->{$this->_field} = strtotime($post[$this->_field . '_date'] . ' ' . $post[$this->_field . '_time']);
	}
}
