# Drivers

## File

Configuration:

    'store' => DOCROOT . 'userfiles' . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . $this->project->id . '/', // Where to store the uploaded file.
    'create' => TRUE, // Set permission to create folder if not existing.
    'call' => FALSE, // No method shall be called on the file.
    'rules' => array(
        array('Upload::not_empty', array(':value')),
        array('Upload::size', array(':value', '1M')),
        array('Upload::type', array(':value', array('pdf', 'doc', 'docx'))),
    ),
    
* `store`: The path to the folder where the file will be saved.
* `create`: If `TRUE` Gaps will automatically create the folder if needed.
* `call`: A callback which will be called on the uploaded file. `FALSE` for no callback.

`rules` are optional. But the `Upload` class can be used to validate size and type of the file.

In addition the generated form must have enctype `multipart/form-data`, so set the attributes of the form manually:

    Gaps::form(ORM::factory('file'))->attributes(array(
        'action' => URL::base() . Route::get(...)->uri(),
        'method' => 'POST',
        'enctype' => 'multipart/form-data',
    ));

For correct loading of the form data use:

    $form->load($_POST, $_FILES);

**Note**: For saving the file after validation call `$form->save_rels()` after saving the corresponding model.
