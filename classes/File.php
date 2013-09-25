<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Extending File class.
 *
 * @package     Gaps
 * @author      David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license     http://opensource.org/licenses/bsd-3-clause
 */
class File extends Kohana_File {

    /**
     * Get the extension of a file.
     *
     * @return	string	extension
     */
    public static function ext($file) {
        $array = explode('.', $file);
        return strtolower(array_pop($array));
    }

}
