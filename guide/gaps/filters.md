# Filters

There are mainly two kinds of filters. The first one are only available for relationship drivers. See their documentation for more information. The second one are usual filters also known from ORM models.

Note that for relationship drivers **only** the first kind of filters is available.

Defining filters for non relationship drivers works similar to defining filters for orm models:

	'filters' => array(
    	// Will format the date according to the second parameter:
        'date' => array(
            array('date', array(':value', 'Y-m-d')),
        ),
    )
