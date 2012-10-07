# Examples

## Users and Entries (Has Many)

Consider the following SQL scheme. This example demonstrates the has many relationship between an entry (maybe a calendar entry) which has many users (i.e. users participating on this entry):

	CREATE  TABLE `project_entries` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `date` INT(11) NOT NULL ,
	  `description` TEXT NULL ,
	  PRIMARY KEY (`id`))
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_general_ci;
	
	CREATE  TABLE `users` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `email` VARCHAR(255) NOT NULL ,
	  `first_name` VARCHAR(255) NOT NULL ,
	  `last_name` VARCHAR(255) NOT NULL ,
	  `password` VARCHAR(65) NOT NULL ,
	  PRIMARY KEY (`id`))
	DEFAULT CHARACTER SET = utf8;
	
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
	    ON UPDATE NO ACTION)
	DEFAULT CHARACTER SET = utf8
	COLLATE = utf8_general_ci;

Now the models:

	class Model_Entry extends ORM
	{
		
		/**
		 * @var	string	table
		 */
		protected $_table_name = 'entries';
		
		/**
		 * @var	array 	has many users
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
		 * @return	array 	configurations
		 */
		public function gaps()
		{
			return array(
				// A entry has many users.
				// I say users can be 'assigned' to the entry.
				// There are two has many drivers: select and default
				'users' => array(
					// Uncomment this line for using the has_many_select driver.
					// 'driver' => 'select',
					// Without given driver the default has many driver based on checkboxes is used.
					'label' => 'Installers',
					// The checkbox labels consists of the last name and the first name seperated by comma.
					'orm' => 'last_name, first_name',
					'rules' => array(
						'not_empty' => array(':value'),
					),
					// Filters:
					// We only select all users with state equals zero
					// and order them by last_name.
					'filters' => array(
						'where' => array('state', '=', '0'),
						'order_by' => array('last_name'),
					),
				),
				// For date input a datepicker could be used.
				// Then a filter could convert the date string to timestamp.
				// See ORM userguide for more informaiton about ORM model filters.
				'date' => array(
					'label' => 'Date',
					'rules' => array(
						'not_empty' => array(':value'),
					),
				),
				// textarea driver for the description.
				'description' => array(
					'label' => 'Description',
					'driver' => 'textarea',
				),
			);
		}
	}
	

	class Model_User extends ORM
	{
	
		/**
		 * @var	array 	has many entries
		 */
		protected $_has_many = array(
			'entries' => array(
				'through' => 'entries_users',
				'model' => 'project_entry',
				'foreign_key' => 'user_id',
				'far_key' => 'project_entry_id',
			),
		);
	
		// Here no gaps configuration.
		// We will focus on creating new entries and assigning users to the entries using gaps.
	}

Note that in both models the has many through relationship is defined properly. See the ORM user guide for more information about has many relationships in ORM models.