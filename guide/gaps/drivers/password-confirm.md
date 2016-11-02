# Drivers

## Password confirm

There are no additional configuration options, but note: password confirm generates two password inputs, but the driver **will not** validate that the two passwords match, the corresponding rules have to be added manually:

    'rules' => array(
        array('min_length', array(':value', 8)),
        array('max_length', array(':value', 32)),
        array('not_empty', array(':value')),
        array('matches', array(':validation', 'password', 'password_confirm')),
    ),
