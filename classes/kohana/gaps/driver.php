<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
abstract class Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used view
	 */
	protected $_view;
	
	/**
	 * @var	string	field
	 */
	protected $_field;
	
	/**
	 * @var	mixed	value
	 */
	protected $_value;
	
	/**
	 * @var	array 	options
	 */
	protected $_options = array();
	
	/**
	 * @var	mixed	error
	 */
	protected $_error = FALSE;
	
	/**
	 * Constructor.
	 * 
	 * @param	string	filed
	 * @param	mixed	value
	 * @param	array 	options
	 * @param	object	model
	 */
	public function __construct($field, $value, $options, $model)
	{
		$this->_field = $field;
		$this->_value = $value;
		$this->_options = $options;
	}
	
	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param	array 	post
	 */
	abstract public function load($model, $post);
	
	/**
	 * Getter for options.
	 * 
	 * @param	string	key
	 * @return	mixed	option
	 */
	public function __get($key)
	{
		return isset($this->_options[$key]) ? $this->_options[$key] : NULL;
	}
	
	/**
	 * Getter for value.
	 * 
	 * @return	mixed	value
	 */
	public function value()
	{
		$value = $this->_value;
		
		if (!isset($this->_rel))
		{
			if (isset($this->_options['filters']))
			{
				foreach ($this->_options['filters'] as $method)
				{
					$value = call_user_func($method, $value);
				}
			}
		}
		return $value;
	}
	
	/**
	 * Getter for field.
	 * 
	 * @return	string	field
	 */
	public function field()
	{
		return $this->_field;
	}
	
	/**
	 * Getter for label.
	 * 
	 * @return	string	label
	 */
	public function label()
	{
		if ( !isset($this->_options['label']) )
		{
			return $this->_field;
		}
		else
		{
			return $this->_options['label'];
		}
	}
	
	/**
	 * Getter for attributes.
	 * 
	 * @return	array 	attributes
	 */
	public function attributes()
	{
		if (!isset($this->_options['attributes']))
		{
			return array();
		}
		else
		{
			return $this->_options['attributes'];
		}
	}
	
	/**
	 * Getter for classes.
	 * 
	 * @return	string	classes
	 */
	public function classes()
	{
		if (!isset($this->_options['attributes']['class']))
		{
			return '';
		}
		else
		{
			return $this->_options['attributes']['class'];
		}
	}
	
	/**
	 * Add validation rules.
	 * 
	 * @param	object	validation
	 */
	public function validation($validation)
	{
		if (isset($this->_options['rules']))
		{
			foreach ($this->_options['rules'] as $rule => $array)
			{
				$validation->rule($this->_field, $rule, $array);
			}
		}
	}
	
	/**
	 * Get error for this driver.
	 * 
	 * @return	string	error
	 */
	public function error()
	{
		return $this->_error;
	}
	
	/**
	 * toString.
	 * 
	 * @return	string	rendered
	 */
	public function __toString()
	{
		return $this->render();
	}
	
	/**
	 * Renders view.
	 * 
	 * @return	string	rendered
	 */
	public function render()
	{
		return View::factory('gaps/' . Kohana::$config->load('gaps.theme') . '/driver/'.$this->_view, array('input' => $this))->render();
	}
}
