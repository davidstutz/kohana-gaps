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
                    array(
                        'belongs_to' => array(
                            'option_key' => 'option_value',
                            'orm' => 'value',
                            // Give a method to get relaitonship models. Otherwise gaps will try ORM::factory('belongs_to') ...
                            'models' => function() {
                                return array();
                            },
                        ),
                    ),
                    array(
                        'has_many' => array(
                            'option_key' => 'option_value',
                            'orm' => 'value',
                            // Give a method to get relaitonship models. Otherwise gaps will try ORM::factory('belongs_to') ...
                            'models' => function() {
                                return array();
                            },
                        ),
                    ),
                    array(
                        'password_confirm' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'bool' => array(

                        ),
                    ),
                    array(
                        'file' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'password' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'select' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'text' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'textarea' => array(
                            'option_key' => 'option_value',
                        ),
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
        
        foreach ($configuration as $group) {
            foreach ($group as $field => $options) {
                
                $driver = $form->{$field};
                
                // Test if the driver occurs in the driver list of the form.
                $this->assertSame(1, sizeof(array_filter($form->_drivers, function($group) use ($field) {
                    return isset($group[$field]);
                })));

                foreach ($options as $key => $value) {
                    $this->assertNotNull($driver->{$key});
                    $this->assertSame($value, $driver->{$key});
                }
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
    
    /**
     * Provides test data for testing rendering different parts of the form.
     *
     * @return array
     */
    public function provider_render() {
        return array(
            array(
                array(
                    array(
                        'bool' => array(

                        ),
                    ),
                    array(
                        'file' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'password' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'select' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'text' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                    array(
                        'textarea' => array(
                            'option_key' => 'option_value',
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * Tests render.
     * 
     * @test
     * @dataProvider provider_render
     * @param   string  method
     * @param   string   object_name
     */
    public function test_render($configuration) {
        $this->_model->gaps($configuration);
        $form = new Gaps_Form($this->_model, 'gaps');
        $form->render();
    }
    
    /**
     * Tests open.
     * 
     * @test
     * @dataProvider provider_render
     * @param   string  method
     * @param   string   object_name
     */
    public function test_open($configuration) {
        $this->_model->gaps($configuration);
        $form = new Gaps_Form($this->_model, 'gaps');
        $form->open();
    }
    
    /**
     * Tests open.
     * 
     * @test
     * @dataProvider provider_render
     * @param   string  method
     * @param   string   object_name
     */
    public function test_close($configuration) {
        $this->_model->gaps($configuration);
        $form = new Gaps_Form($this->_model, 'gaps');
        $form->close();
    }
    
    /**
     * Tests open.
     * 
     * @test
     * @dataProvider provider_render
     * @param   string  method
     * @param   string   object_name
     */
    public function test_content($configuration) {
        $this->_model->gaps($configuration);
        $form = new Gaps_Form($this->_model, 'gaps');
        $form->content();
    }
    
    /**
     * Tests open.
     * 
     * @test
     * @dataProvider provider_render
     * @param   string  method
     * @param   string   object_name
     */
    public function test_submit($configuration) {
        $this->_model->gaps($configuration);
        $form = new Gaps_Form($this->_model, 'gaps');
        $form->submit();
    }
    
    /**
     * Provides test data for testing attributes getter/setter.
     *
     * @return array
     */
    public function provider_attributes() {
        return array(
            array(
                // Testing setter.
                array(
                    'class' => 'form',
                )
            ),
            array(
                // Testing getter.
                NULL,
            ),
        );
    }

    /**
     * Tests constructor.
     * 
     * @test
     * @dataProvider provider_attributes
     * @param   string  method
     * @param   string   object_name
     */
    public function test_attributes($attributes) {
        $form = new Gaps_Form($this->_model, 'gaps');
        
        // Test getter.
        if (NULL === $attributes) {
            $this->assertSame($form->attributes($attributes), array('method' => 'POST'));
        }
        // Test setter.
        elseif (is_array($attributes)) {
            $form->attributes($attributes);
            $this->assertSame($form->attributes(), array_merge(array('method' => 'POST'), $attributes));
        }
        
    }
}