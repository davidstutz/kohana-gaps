# Drivers

## Select

The select driver required the 'options' key to be set:

	':field' => array(
		'label' => 'Label',
		'driver' => 'text',
		'options' => array(
			'First option' => 1,
			'Second option' => 2,
			'third option' => 3,
			// ...
		),
	),
	
The 'options' key i expected to be an array with label => value pars used to generate the option tags for the select.