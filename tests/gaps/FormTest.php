<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests the form.
 *
 * @group gaps
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Gaps_FormTest extends Unittest_TestCase {

    protected $_model;
    
    /**
     * Set up by instantiating the model.
     */
    public function setUp() {
        parent::setUp();
        
        if (!class_exists('TestModel')) {
            require_once 'TestModel.php';
        }
        
        if (!class_exists('TestForm')) {
            require_once 'TestForm.php';
        }
        
        $this->_model = new TestModel();
    }
    
    /**
     * Provides test data for testing constructor.
     *
     * @return array
     */
    public function provider_construct() {
        return array(
            array(
                array(
                    'belongs_to' => array(
                        'option_key' => 'option_value',
                        'orm' => 'value',
                    ),
                    'has_many' => array(
                        'option_key' => 'option_value',
                        'orm' => 'value',
                    ),
                    'password_confirm' => array(
                        'option_key' => 'option_value',
                    ),
                    'bool' => array(
                        
                    ),
                    'file' => array(
                        'option_key' => 'option_value',
                    ),
                    'password' => array(
                        'option_key' => 'option_value',
                    ),
                    'select' => array(
                        'option_key' => 'option_value',
                    ),
                    'text' => array(
                        'option_key' => 'option_value',
                    ),
                    'textarea' => array(
                        'option_key' => 'option_value',
                    ),
                ),
            ),
        );
    }

    /**
     * Tests constructor.
     * 
     * @test
     * @dataProvider provider_construct
     * @param   array   gaps configuration
     */
    public function test_construct($configuration) {
        $this->_model->gaps($configuration);
        $form = new TestForm($this->_model, 'gaps');
        
        foreach ($configuration as $field => $options) {
            // Test if the driver occurs in the driver list of the form.
            $this->assertSame(1, sizeof(array_filter($form->_drivers, function($driver) use ($field) {
                return $driver->field == $field;
            })));
            
            foreach ($options as $key => $value) {
                $this->assertNotNull($form->_drivers[$field]->{$key});
                $this->assertSame($value, $form->_drivers[$field]->{$key});
            }
        }
    }
    
    /**
     * Provides test data for testing constructor exceptions.
     *
     * @return array
     */
    public function provider_construct_exception() {
        return array(
            array(
                'method', // Method for gaps configuration.
                'object_name', // Simulate object name for which no validation file exists.
            ),
            array(
                'gaps_wrong',
                'test_model',
            ),
            array(
                'gaps',
                'object_name',
            ),
        );
    }

    /**
     * Tests constructor.
     * 
     * @test
     * @dataProvider provider_construct_exception
     * @expectedException Gaps_Exception
     * @param   string  method
     * @param   string   object_name
     */
    public function test_construct_exception($method, $object_name) {
        $this->_model->object_name($object_name);
        $form = new Gaps_Form($this->_model, $method);
    }
}