# Drivers

## Has Many

**Note**: For saving the relationships use `$form->save_rels()` after updating/creating the model.

Additional configuration options:

    'orm' => 'last_name, first_name', // This key defines which attributes of the has many relationship should be shown as label of the checkboxes.
    'models' => function() {
        // The models could also be filtered, but this is the default behaviour.
        return ORM::factory('Relationship_Model')->find_all();
    }

The relationship models can be filtered using the `models` option. The `orm` option defines the relationship model's fields to be displayed. Example:

    'orm' => 'last_name, first_name'
    
    //...
    $model->first_name = 'David';
    $model->last_name = 'Stutz';

The model will be displayed as `Stutz, David`.
