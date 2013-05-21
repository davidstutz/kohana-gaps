<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests the select driver.
 *
 * @group gaps
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Gaps_DriverSelectTest extends Unittest_TestCase {

    protected $_model;
    
    /**
     * Set up by instantiating the model.
     */
    public function setUp() {
        parent::setUp();
        
        if (!class_exists('TestModel')) {
            require_once 'TestModel.php';
        }
        
        $this->_model = new TestModel();
    }
    
    /**
     * Provides test data for testing contructor.
     *
     * @return array
     */
    public function provider_cosntruct() {
        return array(
            array(
                array(), // No options.
            ),
        );
    }

    /**
     * Tests cosntructor.
     * 
     * @test
     * @dataProvider provider_cosntruct
     * @expectedException Gaps_Exception
     * @param   array   options
     */
    public function test_construct($options) {
        $driver = new Gaps_Driver_Bool('field', $options, $this->_model);
    }
    
    /**
     * Provides test data for testing load.
     *
     * @return array
     */
    public function provider_load() {
        return array(
            array(
                'text',// Field.
                array(// Post.
                    'text' => 'test',
                ),
                'test', // Expected.
            ),
        );
    }

    /**
     * Tests load.
     * 
     * @test
     * @dataProvider provider_load
     * @param   string  field
     * @param   array   post
     * @param   mixed   expected
     */
    public function test_load($field, $post, $expected) {
        $driver = new Gaps_Driver_Text($field, array(), $this->_model);
        
        $driver->load($this->_model, $post);
        
        $this->assertSame($this->_model->{$field}, $driver->value());
        $this->assertSame($this->_model->{$field}, $expected);
    }
    
    /**
     * Provides test data for testing load exception.
     *
     * @return array
     */
    public function provider_load_exception() {
        return array(
            array(
                'text',// Field.
                array(// Post.
                    
                ),
            ),
            array(
                'text',// Field.
                array(// Post.
                    'text1',
                    'text2',
                    NULL,
                    FALSE,
                ),
            ),
        );
    }
    
    /**
     * Tests load exceptions.
     * 
     * @test
     * @dataProvider provider_load_exception
     * @param   string  field
     * @param   array   post
     */
    public function test_load_exception($field, $post) {
        try {
            $driver = new Gaps_Driver_Select($field, array(), $this->_model);
        
            $driver->load($this->_model, $post);
            
            $this->fail('Gaps_Exception expected.');
        }
        catch (Exception $e) {
            
        }
    }
}