# Drivers

# Belongs To

Configuration:

	':field' => array(
		'models' => array(
			// Example for filters:
			// Select all relationships where 'count' is greater than 100.
			'where' => array('count', '>', 100),
		),
		'orm' => 'name', // This key defines which attributes of the has many relationship should be shown as label of the checkboxes.
		'before' => array(
			__('Select something'),
		),
	),

The relationship models can be filtered using the 'models' key.

'orm' defines a string in which all attribute keys are replaced by the attribute's value of the relationship model.

'before' can be added optional. It must be an array of additional value => label pairs for additional options shown before all other options in the select input.