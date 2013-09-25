# Examples

## File Upload

As example consider the following SQL scheme:

	CREATE  TABLE `files` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `description` TEXT NOT NULL ,
	  `src` TEXT NOT NULL ,
	  `time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
	  PRIMARY KEY (`id`));

The table will store the path to the file and an optional description. Consider the corresponding model:

	class Model_File extends ORM {
		
		/**
		 * @var	string	table
		 */
		protected $_table_name = 'files';
		
		/**
		 * Gaps configuration.
		 * 
		 * @return	array 	gaps configuration
		 */
		public function gaps() {
			return array(
                array(
                    'src' => array(
                        'driver' => 'file',
                        'label' => FALSE,
                        'store' => DOCROOT . 'userfiles' . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . $this->project->id . DIRECTORY_SEPARATOR, // Path to store file.
                        'create' => TRUE, // Set permission to create folder if not existing.
                        'call' => FALSE, // No method shall be called on the file.
                        'filename' => 'id', // id will be replaced by the models id, filename will be replaced by the original filename.
                        'rules' => array(
                            'Upload::not_empty' => array(':value'),
                            'Upload::size' => array(':value', '1M'),
                            'Upload::type' => array(':value', array('pdf', 'doc', 'docx')),
                        ),
                    ),
                ),
                array(
                    'description' => array(
                        'driver' => 'textarea',
                        'label' => 'Description',
                    ),
                ),
			);
		}
	}

Let's have a look at the gaps configuration. The textarea driver should be known. The file driver expects the following configuration keys:

* `store`: The path where to store the file (the path to the folder, **not** the file itself).
* `create`: If `TRUE` Gaps will create the folder if not existing.
* `call`: A callback for the file. `FALSE` for no callback.

Rules are optional. The `Upload` helper can be used to validate size and type of the uploaded file. The path (with file) will be saved in the attribute `src`.

In addition the generated form must have enctype `multipart/form-data`, so set the attributes of the form manually:

	Gaps::form(ORM::factory('file'))->attributes(array(
		'action' => URL::base() . Route::get(...)->uri(),
		'method' => 'POST',
		'enctype' => 'multipart/form-data',
	));

Within the controller load both `$_POST` and `$_FILES` for validation:

    if (Request::POST === $this->request->method()) {
        if ($form->load($_POST, $_FILES)) {
            // No validation errors ...
        }
    }
