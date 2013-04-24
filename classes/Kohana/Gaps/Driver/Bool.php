<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Bool driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Bool extends Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used view
	 */
	protected $_view = 'bool';

	/**
	 * Constructor.
	 * 
	 * @throws	Kohana_exception
	 * @param	string	field
	 * @param	mixed	value
	 * @param	array 	options
	 */
	public function __construct($field, $options, $model)
	{
		parent::__construct($field, $options, $model);
		
		if (!isset($options['options']))
		{
			throw new Kohana_Exception('Gaps: Driver Kohana_Gaps_Driver_Bool requires the \'options\' key to be set.');
		}
		
		if (!isset($options['options']['checked']))
		{
			throw new Kohana_Exception('Gaps: Driver Kohana_Gaps_Driver_Bool requires the \'checked\' key to be set.');
		}
		
		if (!isset($options['options']['unchecked']))
		{
			throw new Kohana_Exception('Gaps: Driver Kohana_Gaps_Driver_Bool requires the \'unchecked\' key to be set.');
		}
	}

	/**
	 * Checks whether bool is checked.
	 * 
	 * @return	boolean	checked
	 */
	public function checked()
	{
		return $this->_options['options']['unchecked'] != $this->_value;
	}

	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param	array 	post
	 */
	public function load($model, $post)
	{
		if (isset($post[$this->field]))
		{
			$model->{$this->field} = $this->_options['options']['checked'];
			$this->_value = $this->_options['options']['checked'];
		}
		else
		{
			$model->{$this->field} = $this->_options['options']['unchecked'];
			$this->_value = $this->_options['options']['unchecked'];
		}
	}
}
