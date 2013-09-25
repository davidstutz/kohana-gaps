# Examples

## Users and User Groups (Belongs To)

This example will demonstrate `belongs_to` relationships. Consider the following SQL tables:

	CREATE  TABLE `user_groups` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `name` VARCHAR(32) NULL ,
	  `description` TEXT NULL ,
	  PRIMARY KEY (`id`) ,
	  UNIQUE INDEX `uniq_name` (`name` ASC) );
	
	CREATE  TABLE `users` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `email` VARCHAR(255) NOT NULL ,
	  `first_name` VARCHAR(255) NOT NULL ,
	  `last_name` VARCHAR(255) NOT NULL ,
	  `password` VARCHAR(65) NOT NULL ,
	  `group_id` INT(11) UNSIGNED NULL ,
	  PRIMARY KEY (`id`) ,
	  UNIQUE INDEX `uniq_email` (`email` ASC) ,
	  INDEX `fk_users_group_id` (`group_id` ASC) ,
	  CONSTRAINT `fk_users_group_id`
	    FOREIGN KEY (`group_id` )
	    REFERENCES `user_groups` (`id` )
	    ON DELETE NO ACTION
	    ON UPDATE NO ACTION)
	DEFAULT CHARACTER SET = utf8;

And the corresponding models:

	/**
	 * User model.
	 */
	class Model_User extends ORM {
	
		/**
		 * @var array 	belongs to group
		 */
		protected $_belongs_to = array(
			'group' => array(
				'model' => 'user_group',
				'foreign_key' => 'group_id',
			),
		);
	
		/**
		 * Gaps configuration for adding new user.
		 * 
		 * @return	array 	configuration
		 */
		public function gaps_new() {
			return array(
                array(
                    'first_name' => array(
                        'label' => 'First name',
                        'rules' => array(
                            array('not_empty', array(':value')),
                        ),
                    ),
                    'last_name' => array(
                        'label' => 'Last name',
                        'rules' => array(
                            array('not_empty', array(':value')),
                        ),
                    ),
                ),
				'email' => array(
					'label' => 'Email',
					'rules' => array(
						array('not_empty', array(':value')),
						array('email', array(':value')),
					),
				),
				'password' => array(
					'label' => 'Password',
					'driver' => 'password_confirm',
					'rules' => array(
						array('min_length', array(':value', 8)),
						array('max_length', array(':value', 32)),
						array('not_empty', array(':value')),
						array('matches', array(':validation', 'password', 'password_confirm')),
					),
				),
				'group' => array(
					'label' => 'Group',
					'rules' => array(
						array('not_empty', array(':value')),
					),
					'orm' => 'name', // Show the name of the groups within the select.
				),
			);
		}
	}
	
	/**
	 * User group model.
	 */
	class Model_User_Group extends Model_Red_User_Group {
	
		/**
		 * @var	array 	has many users
		 */
		protected $_has_many = array(
			'users' => array(
				'model' => 'user',
				'foreign_key' => 'group_id',
			),
		);
	}

The controller action for adding a new user:

	// Create the new user.
	$user = ORM::factory('user');

	// Creat the form based on the gaps_new() configuration method.
	$form = Gaps::form($user, 'gaps_new');

	if (Request::POST === $this->request->method()) {
		// Load and validate the POST input.
		if ($form->load($this->request->post())) {
			// Will save the model and its relationships.
			$form->save();
			// Alternative:
			// $user->save();
			// $form->save_rels(); 
			
			$this->redirect(...);
		}
	}

	// Will automatically show errors if POST request was made but was not valid.
	echo $form;