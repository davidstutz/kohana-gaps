<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Extending HTML helper.
 *
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2012 David Stutz
 * @license		http://www.gnu.org/licenses/gpl-3.0
 */
class HTML extends Kohana_HTML {

	/**
	 * @var  array  preferred order of attributes
	 */
	public static $attribute_order = array
	(
		'enctype',
		'action',
		'method',
		'type',
		'id',
		'name',
		'value',
		'href',
		'src',
		'width',
		'height',
		'cols',
		'rows',
		'size',
		'maxlength',
		'rel',
		'media',
		'accept-charset',
		'accept',
		'tabindex',
		'accesskey',
		'alt',
		'title',
		'class',
		'style',
		'selected',
		'checked',
		'readonly',
		'disabled',
	);
}
