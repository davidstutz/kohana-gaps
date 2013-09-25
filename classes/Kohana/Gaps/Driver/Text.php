<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Text driver.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Text extends Gaps_Driver {

    /**
     * @var string  view
     */
    protected $_view = 'text';
    
    /**
     * Load to load value.
     *
     * @throws  Gaps_Exception
     * @param	object	model
     * @param	array 	post
     */
    public function load($model, $post) {
        
        if (!isset($post[$this->field])) {
            throw new Gaps_Exception('Gaps_Driver_Text: Key \'' . $this->field . '\' does not exist within the loaded data.');
        }
        
        $this->_value = $post[$this->field];
        $model->{$this->field} = $post[$this->field];
    }

}
