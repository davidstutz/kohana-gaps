<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Messages for the test model.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright   (c) 2013 - 2016 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
return array(
    'company' => array(
        'not_empty' => __('Fill the Company.'),
        'default' => __('Company not valid.'),
    ),
    'postcode' => array(
        'numeric' => __('The postcode must contain only numbers.'),
        'default' => __('Postcode not valid.'),
    ),
    'country' => array(
        'not_empty' => __('Select a country.'),
        'default' => __('Country not valid.'),
    ),
);
