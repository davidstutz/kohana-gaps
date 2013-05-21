<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Form.
 *
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
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
     * @var	array 	render groups
     */
    protected $_render = array();

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

        /**
         * Get model, validation file and the gaps configuration of the model.
         */
        $this->_model = $model;
        $this->_attributes = array('method' => 'POST');

        if (!is_array($model->{$method}())) {
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
        foreach ($model->{$method}() as $field => $array) {
            /* Has many. */
            if (FALSE !== array_key_exists($field, $this->_model->has_many())) {
                $array['driver'] = 'has_many' . (isset($array['driver']) ? '_' . $array['driver'] : '');
            }
            /* Has one. */
            elseif (FALSE !== array_key_exists($field, $this->_model->has_one())) {
                $array['driver'] = 'has_one' . (isset($array['driver']) ? '_' . $array['driver'] : '');
            }
            /* Belongs to. */
            elseif (FALSE !== array_key_exists($field, $this->_model->belongs_to())) {
                $array['driver'] = 'belongs_to' . (isset($array['driver']) ? $array['driver'] : '');
            }

            /* No relationship. */
            if (!isset($array['driver'])) {
                $array['driver'] = 'text';
            }

            /* Get driver. */
            $driver = 'Gaps_Driver_' . implode('_', array_map('ucfirst', explode('_', $array['driver'])));

            /* Check for driver. */
            if (!class_exists($driver)) {
                throw new Gaps_Exception('Driver ' . $driver . ' not found.');
            }

            $this->_drivers[$field] = new $driver($field, $array, $this->_model);

            if (isset($array['group'])) {
                if (!isset($this->_render[$array['group']])) {
                    $this->_render[$array['group']] = array();
                }

                $this->_render[$array['group']][] = $field;
            }
            else {
                $this->_render[] = $field;
            }
        }
    }

    /**
     * Loads array of input, usually POST.
     *
     * @param	array 	post
     * @return	boolean	passed validation
     */
    public function load($post) {
        /**
         * Ask all drivers for their validation.
         * They will add needed rules to the validation object.
         */
        $validation = Validation::factory($post);

        foreach ($this->_drivers as $driver) {
            if (is_array($driver->rules)) {
                $validation->rules($driver->field, $driver->rules);
            }

            $driver->load($this->_model, $post);
        }

        /**
         * Check validation.
         * If validation passes the modell will be loaded, meaning the given values will be assigned to the model.
         * Else errors will be saved.
         */
        if (!$validation->check()) {
            $this->_errors = array_merge($validation->errors($this->_validation_file));

            foreach ($this->_drivers as $driver) {
                $driver->error($this->_errors);
            }

            return FALSE;
        }

        return TRUE;
    }

    /**
     * Saves model.
     *
     * If the model is not loaded the model is created. Then relationships are saved.
     */
    public function save() {
        $this->_model->save();
        $this->save_rels();

        return $this;
    }

    /**
     * Saves relationships.
     * Needed for Has many driver. Not needed for belongs to relationships.
     * Will also ahndle anny file uploads.
     */
    public function save_rels() {
        foreach ($this->_drivers as $driver) {
            if (method_exists($driver, 'save_rels')) {
                /* Model is saved in driver if save_rel() method exists. */
                $driver->save_rels();
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
     * @param	string	key
     * @param	mixed	value
     * @return 	mixed this/attributes
     */
    public function attributes($array) {
        $this->_attributes = array_merge($this->_attributes, $array);

        return $this;
    }

    /**
     * Get an attribute driver.
     *
     * @param	string	attribute name
     * @return	object	driver
     */
    public function __get($field) {
        return isset($this->_drivers[$field]) ? $this->_drivers[$field] : NULL;
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
        if ($theme === NULL) {
            $theme = Kohana::$config->load('gaps.theme');
        }

        return View::factory('gaps/' . $theme . '/open', array('attributes' => $this->_attributes))->render();
    }

    /**
     * Returns content of form, including all inputs.
     *
     * @return	string content
     */
    public function content($theme = NULL) {
        if ($theme === NULL) {
            $theme = Kohana::$config->load('gaps.theme');
        }

        return View::factory('gaps/' . $theme . '/content', array(
            'theme' => Kohana::$config->load('gaps.theme'),
            'render' => $this->_render,
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
        if ($theme === NULL) {
            $theme = Kohana::$config->load('gaps.theme');
        }

        return View::factory('gaps/' . $theme . '/submit')->render();
    }

    /**
     * Returns closening tag of form.
     *
     * @return	string	closing tag
     */
    public function close($theme = NULL) {
        if ($theme === NULL) {
            $theme = Kohana::$config->load('gaps.theme');
        }

        return View::factory('gaps/' . $theme . '/close')->render();
    }

    /**
     * Renders form.
     *
     * @return	string	rendered form
     */
    public function render($theme = NULL) {
        if ($theme === NULL) {
            $theme = Kohana::$config->load('gaps.theme');
        }

        return View::factory('gaps/form', array(
            'theme' => $theme,
            'attributes' => $this->_attributes,
            'render' => $this->_render,
            'drivers' => $this->_drivers,
            'errors' => $this->_errors
        ))->render();
    }

}
