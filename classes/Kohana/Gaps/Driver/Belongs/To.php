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
		
		$belongs_to = $model->belongs_to();
		
		$this->_rel = $this->field;
		
		if (isset($belongs_to[$this->field]['model']))
		{
			$this->_rel = $belongs_to[$this->field]['model'];
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
		$this->_value = $post[$this->field];
		$model->{$this->field} = ORM::factory($this->_rel, $post[$this->field]);
	}
	
	/**
	 * Gets relationship models.
	 * 
	 * @return	array 	models
	 */
	public function models()
	{
		$orm = ORM::factory($this->_rel);
		
		if (isset($this->_options['models']) AND is_array($this->_options['models']))
		{
			foreach ($this->_options['models'] as $filter => $args)
			{
				call_user_func_array(array($orm, $filter), $args);
			}
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
