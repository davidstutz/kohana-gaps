# Getting Started

For getting started this short guide will introduce you to the basic idea and concept of Gaps.

The basic steps for using Gaps are the following:

* Set up the gaps configuration method within the model.
* Create a controller action responsible for form creation, validation and saving the model.

So consider the following model 'Contact', based on the given SQL scheme:

	CREATE  TABLE `contacts` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `gender` INT(11) UNSIGNED NULL ,
	  `first_name` VARCHAR(255) NULL ,
	  `last_name` VARCHAR(255) NULL ,
	  `email` VARCHAR(255) NULL ,
	  `phone` VARCHAR(45) NULL ,
	  PRIMARY KEY (`id`));

First step: Set up the model and the gaps configuration method.

	class Model_Contact extends ORM {
		
		/**
		 * @var	string	table
		 */
		protected $_table_name = 'contacts';
		
		/**
		 * Gaps configuration.
		 * 
		 * @return	array 	gaps configuration
		 */
		public function gaps() {
			return array(
                array(
                    'gender' => array(
                        'label' => 'Gender',
                        'rules' => array(
                            array('not_empty', array(':value')),
                        ),
                        'driver' => 'select',
                        'options' => array(
                            1 => __('Mr.'),
                            2 => __('Mrs.'),
                        ),
                    ),
                ),
                array(
                    'first_name' => array(
                        'label' => 'First name',
                    ),
                    'last_name' => array(
                        'label' => 'Last name',
                        'rules' => array(
                            array('not_empty', array(':value')),
                        ),
                    ),
                ),
                array(
                    'email' => array(
                        'label' => 'Email',
                        'rules' => array(
                            array('email', array(':value')),
                        ),
                    ),
                ),
                array(
                    'phone' => array(
                        'label' => 'Phone',
                    ),
                ),
			);
		}
	}

Gaps will use the given configuraiton to generate an appropriate form. Let us have a look at the configuration in detail. Each form element corresponds to an attribute of the model and is rendered using a specified driver. Consider the `last_name`:

    // attribute name => configuration array
    'last_name' => array(
        'label' => 'Last name', // The label is translated automatically.
        // The 'test' driver is the default driver and can be omitted:
        'driver' => 'text',
        // Add rules as known from ORM:
        'rules' => array(
            array('not_empty', array(':value')),
        ),
    ),

Multiple form elements are grouped by putting an additional array around them:

    array(
        'first_name' => array(
            'label' => 'First name',
        ),
        'last_name' => array(
            'label' => 'Last name',
            'rules' => array(
                array('not_empty', array(':value')),
            ),
        ),
    ),

There are drivers provided for all common form elements:

* `text`: text types input
* `password`: password typed input
* `bool`: checkbox
* `file`: file upload
* `textarea`: textarea
* `select`: select

Each driver requires a different set of configuration options. See [here](drivers) for detailed information on the drivers and [here](model-configuration) for a general overview of configuration options. In addition there are drivers provided to handle relationships like `has_many` or `belongs_to` as used by the ORM module.

Second step: The controller action.

	// Create a new contact model.
	$contact = ORM::factory('contact');
	// Gaps requires the contact model and the name of the configuration method.
	$form = Gaps::form($contact, 'gaps');
    
    $this->template->content = $form;

Now you can display the whole form or specific parts of it within the template. For this purpose you can also use [direct access](direct-access) to all form elements.

    // Display the whole form using the given theme.
    $form->render($theme);
    
    // Render specific parts of the form:
    $form->open();
    $form->content(); // All form elements.
    $form->close();

Beneath form generation Gaps will handle validation and in addition save the changes to the model (or create a new one in case it does not exist). Some further changes on the controller action:

	// Create a new contact model.
	$contact = ORM::factory('contact');
	// The method expects the contact model and the name of the configuration file.
	$form = Gaps::form($contact, 'gaps');
	
	// Check for POST request.
	if (Request::POST === $this->request->method()) {
		// If validation passes update/create the model.
		// The load method expects the post array (the data to validate) and loads the values into the model.
		if ($form->load($this->request->post())) {
			$form->save();
		}
	}
	
	// If the form was submitted but did not pass the validation
	// Gaps will automatically add error messages.
	$this->template->content = $form;

This simple example shows the basic set up for working with Gaps. For more advanced examples see [further examples](further-examples.md).
