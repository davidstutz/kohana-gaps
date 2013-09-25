# Drivers

## Bool

Additional required configuration option:

	'options' => array(
		'checked' => TRUE,
		'unchecked' => FALSE,
	),

The bool driver requires the `options` key to be set, containing values for `checked` and `unchecked`. Meaning if the checkbox is checked, the model attribute will be the given value for `checked` after saving and vice versa.