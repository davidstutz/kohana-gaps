<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Has many select driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Has_Many_Select extends Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used view
	 */
	protected $_view = 'has/many/select';
	
	/**
	 * @var	string	relationship model name
	 */
	protected $_rel;
	
	/**
	 * @var	array 	relationships to add
	 */
	protected $_rels = array();
	
	/**
	 * @var	array 	checked relationships
	 */
	protected $_checked = array();
	
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
	public function __construct($field, $value, $options, $model)
	{
		parent::__construct($field, $value, $options, $model);
		
		if (!isset($options['orm']))
		{
			throw new Kohana_Exception('Gaps: Kohana_Driver Gaps_Driver_Belongs_To requires the \'orm\' key to be set.');
		}
		
		if (!is_string($options['orm']))
		{
			throw new Kohana_Exception('Gaps: Kohana_Driver Gaps_Driver_Belongs_To requires the \'orm\' key to be string.');
		}
		
		$this->_model = $model;
		
		$has_many = $model->has_many();
		$this->_rel = $this->_field;
		if (isset($has_many[$this->_field]['model']))
		{
			$this->_rel = $has_many[$this->_field]['model'];
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
		if (isset($post[$this->_field])
			AND is_array($post[$this->_field]))
		{
			$this->_rels = $post[$this->_field];
		}
	}
	
	/**
	 * Saves relationships. Must be done after creating/updating/saving the model.
	 */
	public function save_rels()
	{
		/**
		 * Delete relationships not selected in form and add new ones.
		 */
		foreach ($this->_model->{$this->_field}->find_all() as $model)
		{
			if (FALSE === array_search($model->id, $this->_rels))
			{
				$this->_model->remove($this->_field, $model->id);
			}
		}
		
		foreach ($this->_rels as $id)
		{
			$rel = ORM::factory($this->_rel, $id);
			
			if ($rel->loaded()
				AND !$this->_model->has($this->_field, $rel->id))
			{
				$this->_model->add($this->_field, $rel);
			}
		}
	}
	
	/**
	 * Getter for relationship model.
	 * 
	 * @return	string	model
	 */
	public function rel()
	{
		return $this->_rel;
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