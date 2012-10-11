<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Form.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Form {
	
	/**
	 * @var	array 	drivers
	 */
	protected $_drivers = array();
	
	/**
	 * @var	object	model
	 */
	protected $_model;
	
	/**
	 * @var	array 	has many relationships of model
	 */
	protected $_has_many = array();
	
	/**
	 * @var	array 	has one relationships
	 */
	protected $_has_one = array();
	
	/**
	 * @var	array 	belongs to relationships
	 */
	protected $_belongs_to = array();
	
	/**
	 * @var	array 	errors
	 */
	protected $_errors = array();
	
	/**
	 * @var	array 	attributes
	 */
	protected $_attributes = array();
	
	/**
	 * @var	array 	render groups
	 */
	protected $_render = array();
	
	/**
	 * Constructor.
	 * 
	 * @throws	Kohana_Exception
	 * @param	object	model
	 * @param 	string	configuration method
	 */
	public function __construct($model, $method)
	{
		/**
		 * Check for model and throw exception if it not exists.
		 */
		if (!method_exists($model, $method))
		{
			throw new Kohana_Exception('Gaps: Method \'' . $method . '\' does not exist on ORM model \'' . $model->object_name() . '\'.');
		}
		
		/**
		 * Check for validation file.
		 */
		$file = Kohana::find_file('messages', str_replace('_', '/', $model->object_name()));
		if (empty($file))
		{
			throw new Kohana_Exception('Gaps: Validation file \'' . str_replace('_', '/', $model->object_name()) . '\' not found.');
		}
		
		/**
		 * Get model, validation file and the gaps configuration of the model.
		 */
		$this->_model = $model;
		$this->_attributes = array('method' => 'POST');
		
		$columns = $model->{$method}();
		
		/**
		 * Get and save all relationships.
		 */
		$this->_has_many = $this->_model->has_many();
		$this->_has_one = $this->_model->has_one();
		$this->_belongs_to = $this->_model->belongs_to();
		
		/**
		 * Init all fields.
		 * Each field will be saved as its driver.
		 * 
		 * Default drivers:
		 * - text for normal columns
		 * - has_many for has many relationship columns
		 * - belongs_to for belongs to relationships
		 * - has_one for has one relationships
		 */
		foreach ($columns as $field => $array)
		{
			/* Has many. */
			if (FALSE !== array_key_exists($field, $this->_has_many))
			{
					$array['driver'] = 'has_many' . (isset($array['driver']) ? '_' . ucfirst($array['driver']) : '');
			}
			/* Has one. */
			elseif (FALSE !== array_key_exists($field, $this->_has_one))
			{
					$array['driver'] = 'has_one' . (isset($array['driver']) ? '_' . ucfirst($array['driver']) : '');
			}
			/* Belongs to. */
			elseif (FALSE !== array_key_exists($field, $this->_belongs_to))
			{
					$array['driver'] = 'belongs_to' . (isset($array['driver']) ? $array['driver'] : '');
			}
			/* No relationship. */
			if (!isset($array['driver']))
			{
				$array['driver'] = 'text';
			}
			
			/* Get driver. */
			$parts = explode('_', $array['driver']);
			$driver = 'Gaps_Driver';
			foreach($parts as &$part)
			{
				$driver .=  '_'.ucfirst($part);
			}
			$driver = 'Kohana_Gaps_Driver_'.ucfirst($array['driver']);
			
			/* Check for driver. */
			if (!class_exists($driver))
			{
				throw new Kohana_Exception('Gaps: Driver '.$driver.' not found.');
			}
			
			/* Get current value. */
			if (FALSE !== array_key_exists($field, $this->_has_many))
			{
				$value = $this->_model->{$field}->find_all();
			}
			else
			{
				$value = $this->_model->{$field};
			}
			
			$this->_drivers[$field] = new $driver($field, $value, $array, $this->_model);
			
			if (isset($array['group']))
			{
				if (!isset($this->_render[$array['group']]))
				{
					$this->_render[$array['group']] = array();
				}
				
				$this->_render[$array['group']][] = $field;
			}
			else
			{
				$this->_render[] = $field;
			}
		}
	}
	
	/**
	 * Loads array of input, usually POST.
	 * 
	 * Usage:
	 * 	if (Request::POST === $this->request->method())
	 * 	{
	 * 		if ($form->load($this->request->post())) //Will load POST and check validation
	 * 		{
	 * 			// Save model...
	 * 		}
	 * 	}
	 * 
	 * @param	array 	post
	 * @return	boolean	passed validation
	 * @uses	Validation
	 */
	public function load($post, $files = array())
	{
		/**
		 * Ask all drivers for their validation.
		 * They will add needed rules to the validation object.
		 */
		$validation = Validation::factory($post);
		$file_validation = Validation::factory($files);
		
		foreach ($this->_drivers as $driver)
		{
			$driver->validation($driver instanceof Kohana_Gaps_Driver_File ? $file_validation : $validation);
		}
		
		/**
		 * Check validation.
		 * If validation passes the modell will be loaded, meaning the given values will be assigned to the model.
		 * Else errors will be saved.
		 */
		if ($validation->check()
			AND $file_validation->check())
		{
			foreach ($this->_drivers as $driver)
			{
				$driver->load($this->_model, $driver instanceof Kohana_Gaps_Driver_File ? $files : $post);
			}
			
			return TRUE;
		}
		else
		{
			$this->_errors = array_merge($file_validation->errors(str_replace('_', '/', $this->_model->object_name())), $validation->errors(str_replace('_', '/', $this->_model->object_name())));
			foreach ($this->_drivers as $driver)
			{
				$driver->errors($this->_errors);
			}
			
			return FALSE;
		}
	}
	
	/**
	 * Saves model.
	 * 
	 * Usage:
	 * 	if ($form->load($this->request->post())) //Will load POST and check validation
	 * 	{
	 * 		$form->save();
	 * 	}
	 * 
	 * If the model is not loaded the model is created. Then relationships are saved.
	 */
	public function save()
	{
		$this->_model->save();
		$this->save_rels();
	}
	
	/**
	 * Saves relationships.
	 * Needed for Has many driver. Not needed for belongs to relationships.
	 * Will also ahndle anny file uploads.
	 * 
	 * Usage:
	 * 	if ($form->load($this->request->post())) //Will load POST and check validation
	 * 	{
	 * 		$model->save(); // Save model given to the form.
	 * 		$form->save_rels();
	 * 	}
	 */
	public function save_rels()
	{
		/* Now save relationships. */
		foreach ($this->_drivers as $driver)
		{
			if (method_exists($driver, 'save_rels'))
			{
				/* Model is saved in driver if save_rel() method exists. */
				$driver->save_rels();
			}
		}
	}
	
	/**
	 * Fetch validation messages.
	 * 
	 * @return	array 	messages
	 */
	public function errors()
	{
		return $this->_errors;
	}
	
	/**
	 * Set or get attribute.
	 * 
	 * @param	string	key
	 * @param	mixed	value
	 * @return 	mixed this/attributes
	 */
	public function attributes($array)
	{
		$this->_attributes = $array;
		return $this;
	}
	
	/**
	 * Get an attribute driver.
	 * 
	 * @param	string	attribute name
	 * @return	object	driver
	 */
	public function __get($field)
	{
		return isset($this->_drivers[$field]) ? $this->_drivers[$field] : NULL;
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
	 * Returns opening tag of form.
	 * 
	 * @return	string opening tag
	 */
	public function open()
	{
		return View::factory('gaps/' . Kohana::$config->load('gaps.theme') . '/open', array('attributes' => $this->_attributes))->render();
	}
	
	/**
	 * Returns content of form, including all inputs.
	 * 
	 * @return	string content
	 */
	public function content()
	{
		return View::factory('gaps/' . Kohana::$config->load('gaps.theme') . '/content', array('render' => $this->_render, 'drivers' => $this->_drivers, 'errors' => $this->_errors))->render();
	}
	
	/**
	 * Returns submit button of form.
	 * 
	 * @return	string	submit button
	 */
	public function submit()
	{
		return View::factory('gaps/' . Kohana::$config->load('gaps.theme') . '/submit')->render();
	}
	
	/**
	 * Returns closening tag of form.
	 * 
	 * @return	string	closing tag
	 */
	public function close()
	{
		return View::factory('gaps/' . Kohana::$config->load('gaps.theme') . '/close')->render();
	}
	
	/**
	 * Renders form.
	 * 
	 * @return	string	rendered form
	 */
	public function render()
	{
		return View::factory('gaps/form', array('theme' => Kohana::$config->load('gaps.theme'), 'attributes' => $this->_attributes, 'render' => $this->_render, 'drivers' => $this->_drivers, 'errors' => $this->_errors))->render();
	}
}
