<?php defined('SYSPATH') or die('No direct script access.');

/**
 * File driver.
 * 
 * @package		Gaps
 * @author		David Stutz
 * @copyright	(c) 2013 David Stutz
 * @license		http://opensource.org/licenses/bsd-3-clause
 */
class Kohana_Gaps_Driver_File extends Kohana_Gaps_Driver
{
	
	/**
	 * @var	string	used view
	 */
	protected $_view = 'file';

	/**
	 * @var	array 	files array
	 */
	protected $_files = array();
	
	/**
	 * @var	object	model
	 */
	protected $_model;
	 	
	/**
	 * Load to load value.
	 * 
	 * @param	object	model
	 * @param 	array 	post
	 */
	public function load($model, $files)
	{
		$this->_files = $files;
		$this->_model = $model;
	}
	
	/**
	 * The main action: saving or processing the files is done in save_rels.
	 * 
	 * @throws	Gaps_Exception
	 */
	public function save_rels()
	{
		/**
		 * Files array is directly accessed.
		 */
		if ($this->_options['store'])
		{
			/**
			 * Create dir if allowed.
			 */
			if (!is_dir($this->_options['store']))
			{
				if (!$this->_options['create'])
				{
					throw new Gaps_Exception('Gaps: Directory ' . $this->_options['store'] . ' does not exist.');
				}
				else
				{
					mkdir($this->_options['store'], '0777', TRUE);
				}
			}
			
			/**
			 * If directory is not writable throw exception.
			 */
			if (!is_writable($this->_options['store']))
			{
				throw new Gaps_Exception('Gaps: Directory ' . $this->_options['store'] . ' must be writable.');
			}
			
			$ext = File::ext($this->_files[$this->field]['name']);
			$filename = $this->_files[$this->field]['name'];
			$filename = preg_replace('#.' . $ext . '$#', '', $filename);
			
			if (isset($this->_options['filename']) AND $this->_options['filename'] !== FALSE)
			{
				$filename = strtr($this->_options['filename'], array_merge(array('filename' => $filename), $this->_model->as_array())) . '.' . $ext;
			}
			else
			{
				$filename = $filename . '.' . $ext;
			}
			
			Upload::save($this->_files[$this->field], $filename, $this->_options['store']);
			
			$this->_model->{$this->field} = $filename;
			$this->_model->save();
		}
		if ($this->_options['call'])
		{
			
		}
	}
}
