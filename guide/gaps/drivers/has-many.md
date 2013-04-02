# Drivers

## Has Many

Configuration:

	':field' => array(
		'orm' => 'last_name, first_name', // This key defines which attributes of the has many relationship should be shown as label of the checkboxes.
		'models' => array(
			// Example filters:
			// The filters are applied before the find_all() call.
			// So ordering or where clauses can be applied.
			'where' => array('state', '=', '0'),
			'order_by' => array('last_name'),
		),
	),
	
The relationship models can be filtered using the 'models' key.
	
Gaps automatically detects the has many relationship and uses per default the has many driver. 'orm' defines a string in which all attribute keys are replaced by the attribute's value of the relationship model.

In the example above where 'orm' is 'last_name, first_name' and suppose the relationship model to have the following attributes:

	last_name => Stutz
	first_name => David
	
Then the resulting string shown as labels of the checkboxes is 'Stutz, David'.
