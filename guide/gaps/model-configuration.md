# Model configuration

The configuration is provided by a method of the model:

	/**
	 * Gaps configuration.
	 *
	 * @return 	array	configuration
	 */
	public function gaps() {
		return array(
			// Configuration ...
		);
	}

The default name for this method should be `gaps`. But they can be named different depending on their purpose.

General, driver independant configuration options:

* `label`: The label of the form element. The label is translated automatically.
* `driver`: The driver used for the attribute.
* `rules`: Rules for validation.
* `attributes`: Attributed applied on the form element.
* `filters`: Filters are applied on the given value of the model before displaying it in the form element.

Rules are configured as known from ORM rules. All available rules from the `Valid` class can be used or custom rules can be implemented.

    array(
        'field_name' => array(
            'label' => 'This label will automatically be translated',
            'driver' => 'text',
            'rules' => array(
                array('rules', array(':value')),
            ),
            'filters' => array(
                array('date', array('Y-m-d', ':value')),
            )
            'attributes' => array(
                // HTML attributes here ...
            ),
        ),
    ),

Beneath the general configuration options each driver provides additional configuration options. See the driver documentation for more information.