<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Select driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://www.gnu.org/licenses/gpl-3.0
 */
class Kohana_Gaps_Driver_Select extends Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used driver
	 */
	protected $_view = 'select';

	/**
	 * Constructor.
	 * 
	 * @param	string	field
	 * @param	mixed	value
	 * @param	array 	options
	 */
	public function __construct($field, $value, $options, $model)
	{
		parent::__construct($field, $value, $options, $model);
		
		if ( !isset($options['options']) )
		{
			throw new Kohana_Exception('Gaps: Driver Kohana_Gaps_Driver_Select requires the \'options\' key to be set.');
		}
	}

	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param	mixed	value
	 */
	public function load($model, $post)
	{
		$model->{$this->_field} = $post[$this->_field];
	}
	
	/**
	 * Getter for options.
	 * 
	 * @return	array 	options
	 */
	public function options()
	{
		return $this->_options['options'];
	}
}
