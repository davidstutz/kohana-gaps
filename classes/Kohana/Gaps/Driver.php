<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
abstract class Kohana_Gaps_Driver {
	
	/**
	 * @var	string	used view
	 */
	protected $_view;
	
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
	protected $_error;
	
	/**
	 * Constructor.
	 * 
	 * @param	string	filed
	 * @param	mixed	value
	 * @param	array 	options
	 * @param	object	model
	 */
	public function __construct($field, $options, $model) {
		$this->_value = $model->{$field};
		$this->_options = array_merge($options, array('field' => $field));
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
	public function __get($key) {
		return isset($this->_options[$key]) ? $this->_options[$key] : NULL;
	}
	
	/**
	 * Getter for value.
	 * 
	 * @return	mixed	value
	 */
	public function value() {
	    
        /**
         * The processing of filters is taken from the ORM filters.
         * So ORM filters and usual field filters are behaving equally.
         */
		if (isset($this->_options['filters']) AND is_array($this->_options['filters'])) {
			foreach ($this->_options['filters'] as $array) {
				$filter = $array[0];
				$params = Arr::get($array, 1, array(':value'));
				if (FALSE !== ($key = array_search(':value', $params))) {
					$params[$key] = $this->_value;
				}
				
				if (is_array($filter) OR ! is_string($filter)) {
					$this->_value = call_user_func_array($filter, $params);
				}
				elseif (strpos($filter, '::') === FALSE) {
					$function = new ReflectionFunction($filter);
					$this->_value = $function->invokeArgs($params);
				}
				else {
					list($class, $method) = explode('::', $filter, 2);
					$method = new ReflectionMethod($class, $method);
					$this->_value = $method->invokeArgs(NULL, $params);
				}
			}
		}
		
		return $this->_value;
	}
	
	/**
	 * Get or set error for this driver.
	 * 
	 * @param	mixed	errors
	 * @return	string	error
	 */
	public function error(array $errors = NULL) {
		if ($errors !== NULL) {
			if (isset($errors[$this->field])) {
				$this->_error = $errors[$this->field];
			}
		}
		else {
			return $this->_error;
		}
	}
	
	/**
	 * toString.
	 * 
	 * @return	string	rendered
	 */
	public function __toString() {
		return $this->render();
	}
	
	/**
	 * Renders view.
	 * 
	 * @return	string	rendered
	 */
	public function render($theme = NULL) {
		if ($theme === NULL) {
			$theme = Kohana::$config->load('gaps.theme');
		}
		
		return View::factory('gaps/' . $theme . '/driver/'.$this->_view, array('input' => $this))->render();
	}
}
