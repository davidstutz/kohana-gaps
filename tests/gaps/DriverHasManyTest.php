<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests the belongs to driver.
 *
 * @group gaps
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2016 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Gaps_DriverHasManyTest extends Unittest_TestCase {

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
    public function provider_construct() {
        return array(
            array(
                array(), // No orm option.
            ),
            array(
                array(
                    'orm' => 1, // orm option is not string.
                ),
            ),
            array(
                array(
                    'orm' => '', // orm option is not string.
                ),
            ),
        );
    }

    /**
     * Tests cosntructor.
     * 
     * @test
     * @dataProvider provider_construct
     * @expectedException Gaps_Exception
     * @param   array   options
     */
    public function test_construct($options) {
        $driver = new Gaps_Driver_Has_Many('field', $options, $this->_model);
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
                    // Simulate no relationship models.
                    'models' => function() {
                        return array(
                            new TestModel(array('id' => 1)),
                            new TestModel(array('id' => 1)),
                        );
                    },
                    'orm' => 'id'
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
        $driver = new Gaps_Driver_Has_Many('field', $options, $this->_model);
        $driver->render();
    }
}