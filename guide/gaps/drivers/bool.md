# Drivers

## Bool

The bool driver represents the checkbox. Following configuration is required:

	':field' => array(
		'label' => 'Label',
		'driver' => 'text',
		'options' => array(
			'checked' => TRUE,
			'unchecked' => FALSE,
		),
	),
	
The bool driver requires the 'options' key to be set, containing values for 'checked' and 'unchecked'. Meaning if the checkbox is checked, the model attribute will be the given value for 'checked' after saving. Its the same with 'unchecked'.