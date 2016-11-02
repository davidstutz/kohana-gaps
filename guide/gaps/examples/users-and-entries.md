# Examples

## Users and Entries (Has Many)

Consider the following SQL scheme. This example demonstrates the has many relationship between an entry (maybe a calendar entry) which has many users (i.e. users participating on this entry):

    CREATE  TABLE `entries` (
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
      `date` INT(11) NOT NULL ,
      `description` TEXT NULL ,
      PRIMARY KEY (`id`));
    
    CREATE  TABLE `users` (
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
      `first_name` VARCHAR(255) NOT NULL ,
      `last_name` VARCHAR(255) NOT NULL ,
      PRIMARY KEY (`id`));
    
    CREATE  TABLE `entries_users` (
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
      `entry_id` INT(11) UNSIGNED NULL ,
      `user_id` INT(11) UNSIGNED NULL ,
      `state` INT(11) NOT NULL DEFAULT 0 ,
      PRIMARY KEY (`id`) ,
      INDEX `fk_entries_users_entry_id` (`entry_id` ASC) ,
      INDEX `fk_entries_users_user_id` (`user_id` ASC) ,
      CONSTRAINT `fk_entries_users_entry_id`
        FOREIGN KEY (`entry_id` )
        REFERENCES `entries` (`id` )
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_entries_users_user_id`
        FOREIGN KEY (`user_id` )
        REFERENCES `users` (`id` )
        ON DELETE CASCADE
        ON UPDATE NO ACTION);

With corresponding models:

    class Model_Entry extends ORM {
        
        /**
         * @var    string    table
         */
        protected $_table_name = 'entries';
        
        /**
         * @var    array     has many users
         */
        protected $_has_many = array(
            'users' => array(
                // See ORM userguide for proper usage with has many through relationships.
                'through' => 'entries_users',
                'model' => 'user',
                'foreign_key' => 'entry_id',
                'far_key' => 'user_id',
            ),
        );
        
        /**
         * Gaps configuration.
         * 
         * @return    array     configurations
         */
        public function gaps() {
            return array(
                'users' => array(
                    // Without given driver the default has many driver based on checkboxes is used.
                    'label' => 'Installers',
                    'orm' => 'last_name, first_name',
                    'models' => function() {
                        return ORM::factory('user')->find_all();
                    },
                    'rules' => array(
                        array('not_empty', array(':value')),
                    ),
                ),
                'date' => array(
                    'label' => 'Date',
                    'rules' => array(
                        array('not_empty', array(':value')),
                    ),
                ),
                'description' => array(
                    'label' => 'Description',
                    'driver' => 'textarea',
                ),
            );
        }
    }    

    class Model_User extends ORM {
    
        /**
         * @var    array     has many entries
         */
        protected $_has_many = array(
            'entries' => array(
                'through' => 'entries_users',
                'model' => 'project_entry',
                'foreign_key' => 'user_id',
                'far_key' => 'project_entry_id',
            ),
        );
    }

Pay attention that in both models the `has many` relationship is defined properly.