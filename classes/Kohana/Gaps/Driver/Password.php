<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Password driver.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2016 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Password extends Gaps_Driver {

    /**
     * @var string  view
     */
    protected $_view = 'password';
    
    /**
     * Load to load value.
     *
     * @param	object	model
     * @param	array 	post
     */
    public function load($model, $post) {
        
        if (isset($post[$this->field])) {
            $this->_value = $post[$this->field];
            $model->{$this->field} = $post[$this->field];
        }
    }

}
