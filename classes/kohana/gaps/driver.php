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
	public function __construct($field, $options, $model)
	{
		$this->_value = $model->{$field};
		$this->_field = $field;
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
			if (isset($this->_options['filters']) AND is_array($this->_options['filters']))
			{
				foreach ($this->_options['filters'] as $array)
				{
					// Value needs to be bound inside the loop so we are always using the
					// version that was modified by the filters that already ran
					$_bound[':value'] = $value;
		
					// Filters are defined as array($filter, $params)
					$filter = $array[0];
					$params = Arr::get($array, 1, array(':value'));
		
					foreach ($params as $key => $param)
					{
						if (is_string($param) AND array_key_exists($param, $_bound))
						{
							// Replace with bound value
							$params[$key] = $_bound[$param];
						}
					}
		
					if (is_array($filter) OR ! is_string($filter))
					{
						// This is either a callback as an array or a lambda
						$value = call_user_func_array($filter, $params);
					}
					elseif (strpos($filter, '::') === FALSE)
					{
						// Use a function call
						$function = new ReflectionFunction($filter);
		
						// Call $function($this[$field], $param, ...) with Reflection
						$value = $function->invokeArgs($params);
					}
					else
					{
						// Split the class and method of the rule
						list($class, $method) = explode('::', $filter, 2);
		
						// Use a static method call
						$method = new ReflectionMethod($class, $method);
		
						// Call $Class::$method($this[$field], $param, ...) with Reflection
						$value = $method->invokeArgs(NULL, $params);
					}
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
	public function validation($validation, $post)
	{
		if (isset($post[$this->_field]))
		{
			$this->_value = $post[$this->_field];
		}
		
		if (isset($this->_options['rules']))
		{
			foreach ($this->_options['rules'] as $rule => $array)
			{
				$validation->rule($this->_field, $rule, $array);
			}
		}
	}
	
	/**
	 * Get or set error for this driver.
	 * 
	 * @param	mixed	error/s
	 * @return	string	error
	 */
	public function error($mixed = NULL)
	{
		if ($mixed !== NULL)
		{
			if (is_array($mixed))
			{
				$this->_error = array_key_exists($this->_field, $mixed) ? $mixed[$this->_field] : FALSE;
			}
			else if (is_string($mixed))
			{
				$this->_error = $mixed;
			}
		}
		else
		{
			return $this->_error;
		}
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
