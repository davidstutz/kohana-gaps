# Themes

Gaps supports different themes, describing the generated markup for all drivers.

Currently supported themes:

	* Default
	* Bootstrap
	
## Theme Deveopment

For further theme development both provided themes can be used as example.

Each driver view can access the current driver:

	$input // References the current driver.
	
For all driver the following methods are provided.

	$input->value() // Get the current value.
	$input->filed() // The field name.
	$input->label() // The label for the input configured by the model configuration.
	$input->attributes() // An array containing the configured attributes.
	$input->error() // Error for this driver.
	$input->render() // Equivalent to toString.
