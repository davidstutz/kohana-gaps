# Filters

There are mainly two kinds of filters. The first one are only available for relationship drivers. See their documentation for more information. The second one are usual filters also known from ORM models.

Note that for relationship drivers **only** the first kind of filters is available.

Defining filters for non relationship drivers:

	'filters' => array(
		array('Model_Entry', 'filter'),
	),
	
The 'filters' key expects arrays used for call_user_func(). As parameter the current value of the driver is passed.
