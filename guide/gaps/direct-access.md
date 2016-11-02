# Direct Access

All fields of a created form can directly be accessed to dynamically manipulate configuration options. As example we assumg the following model configuration:

    /**
     * Gaps configuration.
     *
     * @return     array    configuration
     */
    public function gaps() {
        return array(
            array(
                'description' => array(
                    'label' => 'textarea',
                    'driver' => 'textarea',
                    'attributes(
                        'class' => 'editor',
                    ),
                ),
            ),
            array(
                'checked' => array(
                    'label' => 'Checked',
                    'driver' => 'bool',
                    'options' => array(
                        'checked' => 0,
                        'unchecked' => 1,
                    ),
                ),
            ),
        );
    }

Some examples for directly accessing the form elements.

    $model = ORM::factory('model');
    // Create form using the gaps() method of the model.
    $form = Gaps::form($model, 'gaps');
    
    // Suppose the above model configuration.
    // All additional options can be directly addressed (like attributes etc.).
    $form->description->attributes['class'] = 'tinymce';
    
    // Additional getter for label, value, field, classes and attributes are provided:
    if ($form->checked->value() == 0) {
        // ...
    }
    
    echo $form->checked->label(); // == 'Checked'
    
    // If the attributes option is set:
    $attributes = $form->description->attributes;

Direct access and additional methods allow to format the generated markup of your form:

    <!-- Opening tag for form. -->
    <?php echo $form->open(); ?>
        
        <!-- Here all other drivers could be displayed using direct access. -->
        <!-- Or simply display all drivers at once: -->
        <?php echo $form->content(); ?>
    
        <?php echo $form->submit(); ?>
        
    <!-- Closing tag for form. -->
    <?php echo $form->close(); ?>
