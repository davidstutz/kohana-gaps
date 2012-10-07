# Drivers

## File

Configuration:

	':field' => array(
		'store' => DOCROOT . 'userfiles' . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . $this->project->id . '/', // Path to store file.
		'create' => TRUE, // Set permission to create folder if not existing.
		'call' => FALSE, // No method shall be called on the file.
		'rules' => array(
			'Upload::not_empty' => array(':value'),
			'Upload::size' => array(':value', '1M'),
			'Upload::type' => array(':value', array('pdf', 'doc', 'docx')),
		),
	),
	
* store: The path to the folder where the file will be saved.
* create: If TRUE Gaps will automatically create the folder if needed.
* call: A callback. FALSE for no callback.

rules are optional. But the Upload class can be used to validate size and type of the file.

In addition the form generated must be enctype multipart/form-data, so set the attributes of the form manually:
			
	Gaps::form(ORM::factory('file'))->attributes(array(
		'action' => URL::base() . Route::get(...)->uri(),
		'method' => 'POST',
		'enctype' => 'multipart/form-data',
	));