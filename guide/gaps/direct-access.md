# Direct Access

All fields of a created form can be directly accessed to dynamically manipulate configuration options.
Suppose the following model configuration:

	/**
	 * Gaps configuration.
	 *
	 * @return 	array	configuration
	 */
	public function gaps()
	{
		return array(
			'description' => array(
				'label' => 'textarea',
				'driver' => 'textarea',
				'attributes(
					'class' => 'editor',
				),
			),
			'checked' => array(
				'label' => 'Checked',
				'driver' => 'bool',
				'options' => array(
					'checked' => 0,
					'unchecked' => 1,
				),
			),
		);
	}

Now create the form and see some direct access examples:

	$model = ORM::factory('model'); // Create model.
	$form = Gaps::form($model, 'gaps'); // Create form using the gaps() method of the model.
	
	// Suppose the above model configuration.
	// All additional options can be directly addressed (like attributes etc.).
	$form->description->attributes['class'] = 'tinymce';
	
	// Additional getter for label, value, field, classes and attributes are provided:
	if ($form->checked->value() == 0)
	{
		// ...
	}
	
	echo $form->checked->label(); // == 'Checked'
	
	$attributes = $form->description->attributes();
	$classes = $form->description->classes();
	
Using direct access for the options of each driver all configuration keys besides the 'driver' option are accessable.

Direct access and additional methods allow to format the generated markup of your form:

	<!-- Opening tag for form. -->
	<?php echo $form->open(); ?>
		
		<!-- Here all other drivers could be displayed using direct access. -->
		<!-- Or simply display all drivers at once: -->
		<?php echo $form->content(); ?>
	
		<?php echo $form->submit(); ?>
	<!-- Closing tag for form. -->
	<?php echo $form->close(); ?>
