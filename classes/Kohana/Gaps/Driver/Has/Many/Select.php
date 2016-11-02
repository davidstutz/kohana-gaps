<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Has many select driver.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2016 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Has_Many_Select extends Gaps_Driver {

    /**
     * @var    string    relationship model name
     */
    protected $_rel;

    /**
     * @var    object    model
     */
    protected $_model;

    /**
     * @var string  view
     */
    protected $_view = 'has/many/select';
    
    /**
     * Constructor.
     *
     * @throws    Gaps_Exception
     * @param    string    field
     * @param    mixed    value
     * @param    array     options
     */
    public function __construct($field, $options, $model) {
        parent::__construct($field, $options, $model);

        if (!isset($options['orm'])) {
            throw new Gaps_Exception('Driver Gaps_Driver_Has_Many_Select requires the \'orm\' key to be set.');
        }
        
        if (empty($options['orm'])) {
            throw new Gaps_Exception('Driver Gaps_Driver_Has_Many_Select: the \'orm\' key mus tnot be empty.');
        }
        
        if (!is_string($options['orm'])) {
            throw new Gaps_Exception('Driver Gaps_Driver_Has_Many_Select requires the \'orm\' key to be string.');
        }
        
        // Storing model is needed for view.
        $this->_model = $model;
        
        // Get relationship name.
        $has_many = $model->has_many();
        $rel = $this->field;
        if (isset($has_many[$this->field]['model'])) {
            $rel = $has_many[$this->field]['model'];
        }
        
        // To retrieve the models available as relationships the optioon 'models' is a callable returning all models.
        if (!isset($this->_options['models'])) {
            $this->_options['models'] = function() use ($rel) {
                return ORM::factory($rel)->find_all();
            };
        }
        
        $this->_rel = $rel;
    }

    /**
     * Load to load value.
     *
     * @param    object    model
     * @param    array     post
     */
    public function load($model, $post) {
        
        // Relationship models may not exist, so they must not be selected.
        if (isset($post[$this->field])) {
            $this->_value = $post[$this->field];
        }
    }

    /**
     * Saves relationships. Must be done after creating/updating/saving the model.
     * Delete relationships not selected in form and add new ones.
     */
    public function save_rels() {
        foreach ($this->_model->{$this->field}->find_all() as $model) {
            if (FALSE === array_search($model->id, $this->_value)) {
                $this->_model->remove($this->field, $model->id);
            }
        }

        foreach ($this->_value as $id) {
            $rel = ORM::factory($this->_rel, $id);

            if ($rel->loaded() AND !$this->_model->has($this->field, $rel->id)) {
                $this->_model->add($this->field, $rel);
            }
        }
    }

    /**
     * Getter for model
     *
     * @return    object    model
     */
    public function model() {
        return $this->_model;
    }

}
