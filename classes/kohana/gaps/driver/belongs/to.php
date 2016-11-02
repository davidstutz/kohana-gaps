<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Belongs to driver.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2016 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_Belongs_To extends Gaps_Driver {

    /**
     * @var    string    relationship model
     */
    protected $_rel;

    /**
     * @var    object    model
     */
    protected $_model;

    /**
     * @var string  view
     */
    protected $_view = 'belongs/to';
    
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
            throw new Gaps_Exception('Driver Gaps_Driver_Belongs_To requires the \'orm\' key to be set.');
        }
        
        if (empty($options['orm'])) {
            throw new Gaps_Exception('Driver Gaps_Driver_Belongs_To: the \'orm\' key mus tnot be empty.');
        }
        
        if (!is_string($options['orm'])) {
            throw new Gaps_Exception('Driver Gaps_Driver_Belongs_To requires the \'orm\' key to be string.');
        }
        
        // Get the relationhip name.
        $belongs_to = $model->belongs_to();
        $rel = $this->field;
        if (isset($belongs_to[$this->field]['model'])) {
            $rel = $belongs_to[$this->field]['model'];
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
            $model->{$this->field} = ORM::factory($this->_rel, $post[$this->field]);
        }
    }

}
