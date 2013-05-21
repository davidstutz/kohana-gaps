<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Textarea driver.
 *
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Textarea extends Gaps_Driver {

    /**
     * @var	string	used view
     */
    protected $_view = 'textarea';

    /**
     * Load to load value.
     *
     * @param	object	model
     * @param	array 	post
     */
    public function load($model, $post) {
        
        if (!isset($post[$this->field])) {
            throw new Gaps_Exception('Gaps_Driver_Textarea: Key \'' . $this->field . '\' does not exist within the loaded data.');
        }
        
        $this->_value = $post[$this->field];
        $model->{$this->field} = $post[$this->field];
    }

}