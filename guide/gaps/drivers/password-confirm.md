# Drivers

## Password confirm

The password confirm generates two password inputs. The driver **will not** validate that the two passwords match.

Configuration:

	':field' => array(
		'label' => 'Password',
		'driver' => 'password_confirm',
		// Optional rules:
		'rules' => array(
			'min_length' => array(':value', 8),
			'max_length' => array(':value', 32),
			'not_empty' => array(':value'),
			'matches' => array(':validation', 'password', 'password_confirm'),
		),
	),
	
The above configuration shows a advanced configuration for password fields. The rules should be known from Kohana Validation class.
