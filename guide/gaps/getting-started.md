# Getting Started

For getting started this short guide will introduce you to the basic idea and conecpt of Gaps.

The basic steps for using Gaps are the following:

* Set up the gaps configuration method within the model.
* Create a controller action responsible for form creation, validation and saving the model.

So consider the following model 'Contact', based on the given SQL scheme:

	CREATE  TABLE `pl_customer_contacts` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `gender` INT(11) UNSIGNED NULL ,
	  `first_name` VARCHAR(255) NULL ,
	  `last_name` VARCHAR(255) NULL ,
	  `email` VARCHAR(255) NULL ,
	  `phone` VARCHAR(45) NULL ,
	  PRIMARY KEY (`id`))

First step: Set up the model and the gaps configuration method.

	class Model_Contact extends ORM
	{
		
		/**
		 * @var	string	table
		 */
		protected $_table_name = 'contacts';
		
		/**
		 * Gaps configuration.
		 * 
		 * @return	array 	gaps configuration
		 */
		public function gaps()
		{
			return array(
				'gender' => array( // Render the field 'gender'.
					'label' => 'Gender', // The label will be automatically translated.
					'rules' => array( // Define the rules for validation.
						// Formatis the following:
						// 'rule' => array with parmaters (mostly only ':value')
						// Important: the rule name must be the key of the rules array.
						'not_empty' => array(':value'),
					),
					'driver' => 'select', // Used driver for formular, will render this field as select.
					'options' => array( // Define the options of the select. The optios must be given is the select driver is used.
						// Format as follows:
						// value => label
						1 => __('Mr.'),
						2 => __('Mrs.'),
					),
				),
				'first_name' => array( // Render the field 'first_name' with given label.
					'label' => 'First name',
					// If no driver is defined the default driver 'text', meaning normal text input is used.
				),
				'last_name' => array( // Render the field 'last_name' with given label. last_name msut not be empty.
					'label' => 'Last name',
					// 'text' driver...
					'rules' => array(
						'not_empty' => array(':value'),
					),
				),
				'email' => array( // ...
					'label' => 'Email',
					// 'text' driver...
					'rules' => array(
						'email' => array(':value'),
					),
				),
				'phone' => array(
					'label' => 'Phone',
					// 'text' driver...
				),
			);
		}
	}

Second step: The controller action.

	// Create a new contact model.
	$contact = ORM::factory('contact');
	// The method expects the contact model and the name of the configuration file.
	$form = Gaps::form($contact, 'gaps');
	echo $form;
	
Gaps will use the configuration array to render the given files with correct formular elements. See comments for further explanation. Gaps will only render the fields given in the configuration.

As example the following markup was created using the default theme and the 'prefix' option set to 'ui-gaps-':

	<form method="POST">
		<span class="ui-gaps-field">
			<span class="ui-gaps-label">
				<label for="gender"> Geschlecht </label>
			</span>
			<span class="ui-gaps-input">
				<select name="gender">
					<option value="1">Herr</option>
					<option value="2">Frau</option>
				</select>
			</span>
		</span>
		<span class="ui-gaps-field">
			<span class="ui-gaps-label">
				<label for="first_name"> Vorname </label>
			</span>
			<span class="ui-gaps-input">
				<input type="text" name="first_name" value="">
			</span>
		</span>
		<span class="ui-gaps-field">
			<span class="ui-gaps-label">
				<label for="last_name"> Nachname </label>
			</span>
			<span class="ui-gaps-input">
				<input type="text" name="last_name" value="">
			</span>
		</span>
		<span class="ui-gaps-field">
			<span class="ui-gaps-label">
				<label for="email"> E-Mail </label>
			</span>
			<span class="ui-gaps-input">
				<input type="text" name="email" value="">
			</span>
		</span>
		<span class="ui-gaps-field">
			<span class="ui-gaps-label">
				<label for="phone"> Telefon </label>
			</span>
			<span class="ui-gaps-input">
				<input type="text" name="phone" value="">
			</span>
		</span>
		<span class="ui-gaps-submit">
			<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" name="submit" type="submit" role="button" aria-disabled="false">
			<span class="ui-button-text">Bestätigen</span>
			</button>
		</span>
	</form>

But beneath form creation Gaps will handle validation and in addition save the changes to the model (or create a new one in case it does not exist). Some further changes on the controller action:

	// Create a new contact model.
	$contact = ORM::factory('contact');
	// The method expects the contact model and the name of the configuration file.
	$form = Gaps::form($contact, 'gaps');
	
	// Check for POST request.
	if (Request::POST === $this->request->method())
	{
		// Now make validation.
		// If validation passes update/create the model.
		// The load method expects the post array (the data to validate)
		// and loads the values into the model.
		if ($form->load($this->request->post()))
		{
			// Validation passed. So save the model.
			$form->save();
			// As alternativ you could also say:
			// $contact->save();
			// But in case there are relationships you would also need to:
			// $form->save_rels();
		}
	}
	
	// Show the formular.
	// If the form was submitted but did not pass the validation
	// Gaps will automatically add error messages.
	$this->template->content = $form;
	
This simple example shows the basic set up for working with Gaps.

For more advanced examples see [further Examples](further-examples.md).
