# Model configuration

Gaps needs to know which model attributes to render in the formular and which driver to use for each attribute. In addition a lot of options can be specified like label, rules for validation and much more.

For gaps configuration a method returning the configuration array is needed within the model:

	/**
	 * Gaps configuration
	 *
	 * @return 	array	configuration
	 */
	public function gaps()
	{
		return array(
			// Configuration of attributes go here...
		);
	}

The default name for this method should be 'gaps'. But they can be named different dependant on their purpose.

General, driver independant configuration:

* label
* driver
* rules
* group
* attributes

For rules all validation rules known from kohana can be used or individual ones can be created. The validation within Gaps is based on the Kohana Validation class.

	/**
	 * Gaps configuration
	 *
	 * @return 	array	configuration
	 */
	public function gaps()
	{
		return array(
			'attribute_name' => array(
				// Tha label option can be set to FALSE for hiding the label.
				'label' => 'This label will automatically be translated',
				'driver' => 'text', //Use the text driver...
				'rules' => array(
					// Rules go in here...
					'rule' => array(':value', ... ), // Key must be the rule name and value is an array with rule paramters (mostyle only :value).
				),
				// These attributes will be applied on the form element (e.g. text input).
				'attributes' => array(
					'style' => 'style declarations go here',
					'class' => 'classes here',
					'ID' => 'ID here',
				),
			);
		);
	}
	
Beneath the general configuration keys each driver provides additional configuration options. See the driver documentation for more information.