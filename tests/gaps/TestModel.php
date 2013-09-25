<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Test model to test gaps drivers. The model tries to emulate ORM behavior.
 * 
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class TestModel {
    
    /**
     * @var array   data of the model
     */
    protected $_data = array();
    
    /**
     * @var boolean true iff the model was saved
     */
    protected $_saved = FALSE;
    
    /**
     * @var array   gaps configration
     */
    protected $_gaps = array();
    
    /**
     * @var string  object name
     */
    protected $_object_name = 'test_model';
    
    /**
     * Constructor for directly setting data.
     * 
     * @param   array   data
     */
    public function __construct(array $array = NULL) {
        if (NULL !== $array) {
            $this->_cata = $array;
        }
    }
    
    /**
     * Set data.
     * 
     * @param   string  key
     * @param   mixed   value
     */
    public function __set($key, $value) {
        $this->_data[$key] = $value;
    }
    
    /**
     * Get data.
     * 
     * @param   string  key
     * @return  mixed   value
     */
    public function __get($key) {
        return isset($this->_data[$key]) ? $this->_data[$key] : NULL;
    }
    
    /**
     * Emulate saving the model by setting the saved flag to TRUE.
     */
    public function save() {
        $this->_saved = TRUE;
    }
    
    /**
     * Get or set gaps configuration.
     * 
     * @return  array   gaps configuration
     */
    public function gaps($configuration = NULL) {
        if (NULL === $configuration) {
            return $this->_gaps;
        }
        
        $this->_gaps = $configuration;
    }
    
    /**
     * Returns invalid gaps configuration.
     * 
     * @return mixed invalid
     */
    public function gaps_invalid() {
        return 'string';
    }
    
    /**
     * Get or set the object name.
     * 
     * @return  string  test_model
     */
    public function object_name($object_name = NULL) {
        if (NULL === $object_name) {
            return $this->_object_name;
        }
        
        $this->_object_name = $object_name;
    }
    
    /**
     * Simulate belongs to.
     * 
     * @return  array   belongs to
     */
    public function belongs_to() {
        return array(
            'belongs_to' => array(
                
            ),
        );
    }
    
    /**
     * Simulate has many.
     * 
     * @return  array   belongs to
     */
    public function has_many() {
        return array(
            'has_many' => array(
            
            ),
        );
    }
    
    /**
     * Simulate has one.
     * 
     * @return  array   belongs to
     */
    public function has_one() {
        return array(
            'has_one' => array(
            
            ),
        );
    }
    
    /**
     * Get the data as array.
     * 
     * @return  array   data
     */
    public function as_array() {
        return $this->_data;
    }
    
    /**
     * Check whether the model has a certain relationship.
     * 
     * @param   string  model
     * @param   object  relationship
     * @return  boolean has
     */
    public function has($string, $model) {
        return TRUE;
    }
}
