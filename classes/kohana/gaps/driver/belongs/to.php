<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Belongs to driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Belongs_To extends Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used view
	 */
	protected $_view = 'belongs/to';

	/**
	 * @var	string	relationship model
	 */
	protected $_rel;
	
	/**
	 * @var	object	model
	 */
	protected $_model;
	
	/**
	 * Constructor.
	 * 
	 * @throws	Kohana_Exception
	 * @param	string	field
	 * @param	mixed	value
	 * @param	array 	options
	 */
	public function __construct($field, $options, $model)
	{
		parent::__construct($field, $options, $model);
		
		if (!isset($options['orm']))
		{
			throw new Kohana_Exception('Gaps: Driver Kohana_Gaps_Driver_Belongs_To requires the \'orm\' key to be set.');
		}
		
		if (!is_string($options['orm']))
		{
			throw new Kohana_Exception('Gaps: Kohana_Driver Gaps_Driver_Belongs_To requires the \'orm\' key to be string.');
		}
		
		$this->_model = $model;
		/* Get relationship model. */
		$belongs_to = $model->belongs_to();
		$this->_rel = $this->_field;
		if ( isset($belongs_to[$this->_field]['model']) )
		{
			$this->_rel = $belongs_to[$this->_field]['model'];
		}
	}

	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param	array 	post
	 */
	public function load($model, $post)
	{
		$model->{$this->_field} = ORM::factory($this->_rel, $post[$this->_field]);
	}
	
	/**
	 * Getter for relationship model.
	 * 
	 * @return	string	relationship model
	 */
	public function rel()
	{
		return $this->_rel;
	}
	
	/**
	 * Get elements to insert before orm models.
	 * 
	 * @return	array 	before
	 */
	public function before()
	{
		if (isset($this->_options['before']))
		{
			return $this->_options['before'];
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * Getter for ORM vals.
	 * 
	 * @return	array 	orm vals
	 */
	public function orm()
	{
		return $this->_options['orm'];
	}
	
	/**
	 * Getter for options.
	 * 
	 * @return	array 	options
	 */
	public function options()
	{
		return isset($this->_options['options'])? $this->_options['options']: array();
	}
	
	/**
	 * Gets relationship models.
	 * 
	 * @return	array 	models
	 */
	public function models()
	{
		$orm = Orm::factory($this->_rel);
		
		$filters = isset($this->_options['filters'])? $this->_options['filters'] : array();
		foreach ($filters as $filter => $args)
		{
			call_user_func_array(array($orm, $filter), $args);
		}
		
		return $orm->find_all();
	}
	
	/**
	 * Getter for model
	 * 
	 * @return	object	model
	 */
	public function model()
	{
		return $this->_model;
	}
}
