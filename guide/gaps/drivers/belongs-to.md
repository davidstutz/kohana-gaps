# Drivers

## Belongs To

**Note**: For saving the relationships use `$form->save_rels()` after updating/creating the model.

Additional configuration options:

    // This function will return the models the user can choose of.
	'models' => function() {
        return ORM::factory('relationship_model')->find_all();
    }
	'orm' => 'name', // This key defines which attributes of the has many relationship should be shown as label of the checkboxes.

The relationship models can be filtered using the `models` option. The `orm` option defines the attributes of the relationship model to be displayed. Example:

    'orm' => 'last_name, first_name'
    
    //...
    $model->first_name = 'David';
    $model->last_name = 'Stutz';

The model will be displayed as `Stutz, David`.