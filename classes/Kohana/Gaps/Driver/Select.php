<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Select driver.
 *
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Select extends Gaps_Driver {

    /**
     * @var	string	used driver
     */
    protected $_view = 'select';

    /**
     * Constructor.
     *
     * @throws  Gaps_Exception
     * @param	string	field
     * @param	mixed	value
     * @param	array 	options
     */
    public function __construct($field, $options, $model) {
        parent::__construct($field, $options, $model);

        if (!isset($options['options'])) {
            throw new Gaps_Exception('Driver Gaps_Driver_Select requires the \'options\' key to be set.');
        }
    }

    /**
     * Load to load value.
     *
     * @param	object	model
     * @param	mixed	value
     */
    public function load($model, $post) {
        
        if (!isset($post[$this->field])) {
            throw new Gaps_Exception('Gaps_Driver_Select: Key \'' . $this->field . '\' does not exist within the loaded data.');
        }
        
        $this->_value = $post[$this->field];
        $model->{$this->field} = $post[$this->field];
    }

    /**
     * Getter for options.
     *
     * @return	array 	options
     */
    public function options() {
        return $this->_options['options'];
    }

}
