<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests the password confirm driver.
 *
 * @group gaps
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2014 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Gaps_DriverPasswordConfirmTest extends Unittest_TestCase {

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
        $driver = new Gaps_Driver_Password_Confirm($field, array(), $this->_model);
        
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
     * @expectedException Gaps_Exception
     * @param   string  field
     * @param   array   post
     */
    public function test_load_exception($field, $post) {
        $driver = new Gaps_Driver_Password_Confirm($field, array(), $this->_model);
    
        $driver->load($this->_model, $post);
    }
    
    /**
     * Provides test data for testing rendering.
     *
     * @return array
     */
    public function provider_render() {
        return array(
            array(
                array(
                    
                ),
            ),
        );
    }

    /**
     * Tests cosntructor.
     * 
     * @test
     * @dataProvider provider_render
     * @param   array   options
     */
    public function test_render($options) {
        $driver = new Gaps_Driver_Password_Confirm('field', $options, $this->_model);
        $driver->render();
    }
}