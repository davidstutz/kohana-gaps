<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Gaps - a module for generating forms using ORM models.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright	(c) 2013 - 2014 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps {

    /**
     * Create new form.
     *
     * @param	object	model
     * @param	string	method for configuration
     * @return	object	form
     */
    public static function form($model, $method = 'gaps') {
        return new Gaps_Form($model, $method);
    }

}
