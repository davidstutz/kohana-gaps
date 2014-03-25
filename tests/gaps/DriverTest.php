<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests the form.
 *
 * @group gaps
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2014 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Gaps_DriverTest extends Unittest_TestCase {

    protected $_model;
    
    /**
     * Set up by instantiating the model.
     */
    public function setUp() {
        parent::setUp();
        
        if (!class_exists('TestModel')) {
            require_once 'TestModel.php';
        }
        
        if (!class_exists('TestDriver')) {
            require_once 'TestDriver.php';
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
                    'option_key_1' => 'option_value_1',
                    'option_key_2' => array(
                        'suboption_key_1' => TRUE,
                    ),
                    // Gaps will automatically add the label and attributes option if not found.
                    'label' => '',
                    'attributes' => array(),
                ),
                'string',
            ),
            array(
                array(
                    'option_key_1' => 'option_value_1',
                    'option_key_2' => array(
                        'suboption_key_1' => TRUE,
                    ),
                    // Gaps will automatically add the label and attributes option if not found.
                    'label' => '',
                    'attributes' => array(),
                ),
                FALSE,
            ),
            array(
                array(
                    'option_key_1' => 'option_value_1',
                    'option_key_2' => array(
                        'suboption_key_1' => TRUE,
                    ),
                    // Gaps will automatically add the label and attributes option if not found.
                    'label' => '',
                    'attributes' => array(),
                ),
                NULL,
            ),
        );
    }

    /**
     * Tests constructor.
     * 
     * @test
     * @dataProvider provider_construct
     * @param   array   options
     * @param   mixed   value
     */
    public function test_construct($options, $value) {
        $this->_model->field = $value;
        $driver = new TestDriver('field', $options, $this->_model);
        
        $this->assertSame($value, $driver->_value);
        $this->assertSame(array_merge($options, array('field' => 'field')), $driver->_options);
    }
    
    /**
     * Provides test data for testing value getter.
     *
     * @return array
     */
    public function provider_value() {
        $time = time();
        
        return array(
            array(
                $time,
                array(
                    array('date', array('Y-m-d', ':value')),
                ),
                date('Y-m-d', $time),
            ),
            array(
                $time,
                array(
                    array('Gaps_DriverTest::date', array('Y-m-d', ':value')),
                ),
                date('Y-m-d', $time),
            ),
            array(
                $time,
                array(
                    array(array($this, 'date2'), array('Y-m-d', ':value')),
                ),
                date('Y-m-d', $time),
            ),
        );
    }
    
    /**
     * Static wrapper for date.
     * 
     * @param   string  format
     * @param   mixed   now
     * @return  string  formatted
     */
    public static function date($format, $now) {
        return date($format, $now);
    }
    
    /**
     * Wrapper for date.
     * 
     * @param   string  format
     * @param   mixed   now
     * @return  string  formatted
     */
    public function date2($format, $now) {
        return date($format, $now);
    }
    
    /**
     * Tests value getter.
     * 
     * @test
     * @dataProvider provider_value
     * @param   mixed   value
     * @param   array   filters
     * @param   mixed   expected
     */
    public function test_value($value, $filters, $expected) {
        $this->_model->field = $value;
        $driver = new TestDriver('field', array(
            'filters' => $filters,
        ), $this->_model);
        
        $this->assertSame($expected, $driver->value());
    }
}