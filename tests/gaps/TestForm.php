<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Override form for testing to access the protected attributes.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class TestForm extends Gaps_Form {

    /**
     * @var array   drivers
     */
    public $_drivers = array();

    /**
     * @var object  model
     */
    public $_model;
}
