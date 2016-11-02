<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests the bool driver.
 *
 * @group gaps
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2016 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Gaps_DriverBoolTest extends Unittest_TestCase {

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
                array(), // No options.
            ),
            array(
                array(
                    'options' => array(
                        // Empty options array.
                    ),
                ),
            ),
            array(
                array(
                    'options' => array(
                        // Only checked.
                        'checked' => TRUE,
                    ),
                ),
            ),
            array(
                array(
                    'options' => array(
                        // Only unchecked
                        'unchecked' => FALSE,
                    ),
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
                'bool',// Field.
                array( // Options.
                    'options' => array(
                        'checked' => TRUE,
                        'unchecked' => FALSE,
                    ),
                ),
                array(// Post.
                    'boo' => 'test',
                ),
                FALSE, // Checked?
                FALSE, // Expected.
            ),
            array(
                'bool',
                array(
                    'options' => array(
                        'checked' => TRUE,
                        'unchecked' => FALSE,
                    ),
                ),
                array(
                    'bool' => 'test',
                ),
                TRUE,
                TRUE,
            ),
            array(
                'bool',
                array(
                    'options' => array(
                        'checked' => 'checked',
                        'unchecked' => 'unchecked',
                    ),
                ),
                array(
                    'bool' => 'test',
                ),
                TRUE,
                'checked',
            ),
            array(
                'bool',
                array(
                    'options' => array(
                        'checked' => 'checked',
                        'unchecked' => 'unchecked',
                    ),
                ),
                array(
                    
                ),
                FALSE,
                'unchecked',
            ),
        );
    }

    /**
     * Tests load.
     * 
     * @test
     * @dataProvider provider_load
     * @param   string  field
     * @param   array   options
     * @param   array   post
     * @param   mixed   expected
     */
    public function test_load($field, $options, $post, $checked, $exptected) {
        $driver = new Gaps_Driver_Bool($field, $options, $this->_model);
        
        $driver->load($this->_model, $post);
        
        $this->assertSame($this->_model->{$field}, $driver->value());
        $this->assertSame($this->_model->{$field}, $checked ? $options['options']['checked'] : $options['options']['unchecked']);
    }
    
    /**
     * Provides data for testing checked.
     * 
     * @return  array
     */
    public function provider_checked() {
        return array(
            array(
                array( // Options.
                    'options' => array(
                        'checked' => TRUE,
                        'unchecked' => FALSE,
                    ),
                ),
                FALSE, // Model value.
                FALSE, // Expected.
            ),
            array(
                array( // Options.
                    'options' => array(
                        'checked' => time(),
                        'unchecked' => 0,
                    ),
                ),
                0, // Model value.
                FALSE, // Expected.
            ),
            array(
                array( // Options.
                    'options' => array(
                        'checked' => time(),
                        'unchecked' => 0,
                    ),
                ),
                time(), // Model value.
                TRUE, // Expected.
            ),
        );
    }
    
    /**
     * Tests checked.
     * 
     * @test
     * @dataProvider provider_checked
     * @param   array   options
     * @param   mixed   model value
     * @param   mixed   expected
     */
    public function test_checked($options, $value, $expected) {
        $this->_model->field = $value;
        $driver = new Gaps_Driver_Bool('field', $options, $this->_model);
        
        $this->assertSame($this->_model->field, $value);
        $this->assertSame($driver->checked(), $expected);
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
                    'options' => array(
                        'checked' => 1,
                        'unchecked' => 0,
                    ),
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
        $driver = new Gaps_Driver_Bool('field', $options, $this->_model);
        $driver->render();
    }
}