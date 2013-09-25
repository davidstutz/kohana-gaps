<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Form.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Form {

    /**
     * @var	array 	drivers
     */
    protected $_drivers = array();

    /**
     * @var	object	model
     */
    protected $_model;

    /**
     * @var	array 	errors
     */
    protected $_errors = array();

    /**
     * @var	array 	attributes
     */
    protected $_attributes = array();

    /**
     * @var	string	validation file
     */
    protected $_validation_file;

    /**
     * Constructor.
     *
     * @throws	Gaps_Exception
     * @param	object	model
     * @param 	string	configuration method
     */
    public function __construct($model, $method) {
        /**
         * Check for model and throw exception if it not exists.
         */
        if (!method_exists($model, $method)) {
            throw new Gaps_Exception('Method \'' . $method . '\' does not exist on ORM model \'' . $model->object_name() . '\'.');
        }

        /**
         * Check for validation file.
         */
        $this->_validation_file = str_replace('_', DIRECTORY_SEPARATOR, $model->object_name());

        if (!Kohana::find_file('messages', $this->_validation_file)) {
            throw new Gaps_Exception('Validation file \'' . $this->_validation_file . '\' not found.');
        }

        $this->_model = $model;
        $this->_attributes = array('method' => 'POST');
        
        // Get the configuration and validate.
        $configuration = $model->{$method}();
        if (!is_array($configuration)) {
            throw new Gaps_Exception('Method \'' . $method . '\' does not return an array.');
        }
        
        /**
         * Init all fields.
         * Each field will be saved as its driver.
         *
         * Default drivers:
         * - text for normal columns
         * - has_many for has many relationship columns
         * - belongs_to for belongs to relationships
         * - has_one for has one relationships
         */
        foreach ($configuration as $group) {
            
            // TODO: maybe also allow the "old" configuration style.
            
            // Fetch all drivers of this group.
            $drivers = array();
            
            foreach ($group as $field => $array) {
                
                // Drivers for relationships.
                if (FALSE !== array_key_exists($field, $this->_model->has_many())) {
                    $array['driver'] = 'has_many' . (isset($array['driver']) ? '_' . $array['driver'] : '');
                }
                elseif (FALSE !== array_key_exists($field, $this->_model->has_one())) {
                    $array['driver'] = 'has_one' . (isset($array['driver']) ? '_' . $array['driver'] : '');
                }
                elseif (FALSE !== array_key_exists($field, $this->_model->belongs_to())) {
                    $array['driver'] = 'belongs_to' . (isset($array['driver']) ? $array['driver'] : '');
                }
                
                // Default text driver.
                if (!isset($array['driver'])) {
                    $array['driver'] = 'text';
                }
                
                $driver = 'Gaps_Driver_' . implode('_', array_map('ucfirst', explode('_', $array['driver'])));

                if (!class_exists($driver)) {
                    throw new Gaps_Exception('Driver ' . $driver . ' not found.');
                }

                $drivers[$field] = new $driver($field, $array, $this->_model);
            }
            
            // Structure of groups will be kept.
            $this->_drivers[] = $drivers;
        }
    }

    /**
     * Loads array of input, usually POST.
     *
     * @param   array   post
     * @return  boolean passed validation
     */
    public function load($post, $files = NULL) {
        $validation = Validation::factory($post);
        
        if (!is_array($files)) {
            $files = array();
        }
        
        $validation_files = Validation::factory($files);

        /**
         * Ask all drivers for their validation.
         * They will add needed rules to the validation object.
         */
        foreach ($this->_drivers as $group) {
            foreach ($group as $driver) {
                if ($driver instanceof Gaps_Driver_File) {
                    // Assume rules always given as array.
                    if (isset($driver->rules)) {
                        $validation_files->rules($driver->field, $driver->rules);
                    }

                    $driver->load($this->_model, $files);
                }
                else {
                    if (isset($driver->rules)) {
                        $validation->rules($driver->field, $driver->rules);
                    }

                    $driver->load($this->_model, $post);
                }
            }
        }

        /**
         * Check validation.
         * If validation passes the modell will be loaded, meaning the given values will be assigned to the model.
         * Else errors will be saved.
         */
        if (!$validation->check() OR !$validation_files->check()) {
            $this->_errors = array_merge($validation_files->errors($this->_validation_file), $validation->errors($this->_validation_file));

            foreach ($this->_drivers as $group) {
                foreach ($group as $driver) {
                    $driver->error($this->_errors);
                }
            }

            return FALSE;
        }

        return TRUE;
    }

    /**
     * Saves model.
     * If the model is not loaded the model is created. Then relationships are saved.
     * 
     * @return  object  this
     */
    public function save() {
        $this->_model->save();
        // Save relationships and uplaoded files.
        $this->save_rels();

        return $this;
    }

    /**
     * Saves relationships.
     * Needed for Has many driver and file driver. Not needed for belongs to relationships.
     * 
     * @return  object  this
     */
    public function save_rels() {
        foreach ($this->_drivers as $group) {
            foreach ($group as $driver) {
                if (method_exists($driver, 'save_rels')) {
                    $driver->save_rels();
                }
            }
        }

        return $this;
    }

    /**
     * Fetch validation messages.
     *
     * @return	array 	messages
     */
    public function errors() {
        return $this->_errors;
    }

    /**
     * Set or get attribute.
     *
     * @param	array	attributes
     * @return 	mixed this/attributes
     */
    public function attributes($attributes = NULL) {
        if ($attributes === NULL) {
            return $this->_attributes;
        }
        else {
            $this->_attributes = array_merge($this->_attributes, $attributes);
            return $this;
        }
    }

    /**
     * Get an attribute driver.
     *
     * @param	string	attribute name
     * @return	object	driver
     */
    public function __get($field) {
        foreach ($this->_drivers as $group) {
            if (isset($group[$field])) {
                return $group[$field];
            }
        }
        
        return NULL;
    }

    /**
     * toString.
     *
     * @return	string	rendered
     */
    public function __toString() {
        return $this->render();
    }

    /**
     * Returns opening tag of form.
     *
     * @return	string opening tag
     */
    public function open($theme = NULL) {
        return View::factory('gaps/' . $this->_theme($theme) . '/open', array('attributes' => $this->_attributes))->render();
    }

    /**
     * Returns content of form, including all inputs.
     *
     * @return	string content
     */
    public function content($theme = NULL) {
        return View::factory('gaps/' . $this->_theme($theme) . '/content', array(
            'theme' => Kohana::$config->load('gaps.theme'),
            'drivers' => $this->_drivers,
            'errors' => $this->_errors
        ))->render();
    }

    /**
     * Returns submit button of form.
     *
     * @return	string	submit button
     */
    public function submit($theme = NULL) {
        return View::factory('gaps/' . $this->_theme($theme) . '/submit')->render();
    }

    /**
     * Returns closening tag of form.
     *
     * @return	string	closing tag
     */
    public function close($theme = NULL) {
        return View::factory('gaps/' . $this->_theme($theme) . '/close')->render();
    }

    /**
     * Renders form.
     *
     * @return	string	rendered form
     */
    public function render($theme = NULL) {
        return View::factory('gaps/form', array(
            'theme' => $this->_theme($theme),
            'attributes' => $this->_attributes,
            'drivers' => $this->_drivers,
            'errors' => $this->_errors
        ))->render();
    }

    /**
     * Determine the theme to use.
     * 
     * @param   string  theme
     */
    protected function _theme($theme) {
        if ($theme === NULL) {
            $theme = Kohana::$config->load('gaps.theme');
        }
        
        if (!is_dir(MODPATH . 'gaps' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'gaps' . DIRECTORY_SEPARATOR . $theme)) {
            throw new Gaps_Exception('Theme \'' . $theme . '\' not found.');
        }

        return $theme;
    }
    
}
