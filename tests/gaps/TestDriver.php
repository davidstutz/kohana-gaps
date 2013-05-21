<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Test driver. Ovverride abstractz to get access to protected attributes.
 * 
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class TestDriver extends Gaps_Driver {
    
    /**
     * @var array   options
     */
    public $_options = array();
    
    /**
     * @var mixed   value
     */
    public $_value;
    
    /**
     * Load to load value.
     * 
     * @param   object  model
     * @param   array   post
     */
    public function load($model, $post) {
        // empty implementation.   
    }
}
