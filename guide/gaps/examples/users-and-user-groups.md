# Examples

## Users and User Groups (Belongs To)

This example will demonstrate belongs to relationships in combination will normal text drivers and password comfirm drivers.

Consider the following models based on the follwing SQL scheme:

	-- -----------------------------------------------------
	-- Table `user_groups`
	-- -----------------------------------------------------
	CREATE  TABLE `user_groups` (
	  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
	  `name` VARCHAR(32) NULL ,
	  `description` TEXT NULL ,
	  PRIMARY KEY (`id`) ,
	  UNIQUE INDEX `uniq_name` (`name` ASC) );
	
	
	-- -----------------------------------------------------
	-- Table `users`
	-- -----------------------------------------------------
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
	
See the models:

	/**
	 * User model.
	 */
	class Model_User extends ORM
	{
	
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
		public function gaps_new()
		{
			return array(
				// The first name can not be empty and belongs to the formular group 'name'.
				// Drivers with the same group will be rendered in an additional span and so 
				// they can be styled seperately or displayed in one line.
				'first_name' => array(
					'label' => 'First name',
					'rules' => array(
						'not_empty' => array(':value'),
					),
					'group' => 'name',
				),
				// The last name can not be empty and belongs to the formular group 'name'.
				'last_name' => array(
					'label' => 'Last name',
					'rules' => array(
						'not_empty' => array(':value'),
					),
					'group' => 'name',
				),
				// The email must not be empty and has to be a valid email.
				'email' => array(
					'label' => 'Email',
					'rules' => array(
						'not_empty' => array(':value'),
						'email' => array(':value'),
						'Model_User::unique_email' => array(':value'),
					),
				),
				// For the password the password_confirm driver is used.
				// The rules will ensure that both password match and set bounds for the length of the password.
				'password' => array(
					'label' => 'Password',
					'driver' => 'password_confirm',
					'rules' => array(
						'min_length' => array(':value', 8),
						'max_length' => array(':value', 32),
						'not_empty' => array(':value'),
						'matches' => array(':validation', 'password', 'password_confirm'),
					),
				),
				// The group is the user group this user will belong to.
				// The group must be given (thus can not be empty).
				// The 'orm' key will define which attribute of the user group will be shown as option in the select.
				// A string 'name' is given. Within this stirng 'name' is replaced by $group->name.
				'group' => array(
					'label' => 'Group',
					'rules' => array(
						'not_empty' => array(':value'),
					),
					'orm' => 'name',
				),
			);
		}
	
		/**
		 * Gaps configuraiton for changing password.
		 * 
		 * @return	array 	configuration
		 */
		public function gaps_password()
		{
			return array(
				// The password configuration is the same as seen above.
				'password' => array(
					'label' => 'Password',
					'driver' => 'password_confirm',
					'rules' => array(
						'not_empty' => array(':value'),
						'min_length' => array(':value', 8),
						'max_length' => array(':value', 32),
						'matches' => array(':validation', 'password', 'password_confirm'),
					),
				),
			);
		}
	}
	
	/**
	 * User group model.
	 */
	class Model_User_Group extends Model_Red_User_Group
	{
	
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
	
The user belongs to a given user group, and thus each group has many users.

We add two gaps configuration methods to the user model: one for adding a new user and one for changing the password of a user.

The controller action for adding a new user:

	// Create the new user.
	$user = ORM::factory('user');

	// Creat the form based on the gaps_new() configuration method.
	$form = Gaps::form($user, 'gaps_new');

	if (Request::POST === $this->request->method())
	{
		// Load and validate the POST input.
		if ($form->load($this->request->post()))
		{
			// Will save the model and its relationships.
			$form->save();
			// Alternative:
			// $user->save();
			// $form->save_rels(); // Save the group relationship.
			
			$this->redirect(...);
		}
	}

	// Will automatically show errors if POST request was made but was not valid.
	echo $form;
	
Controller action for changing the password:

	// Create the new user.
	$user = ORM::factory('user');
	
	// Create the form based on the gaps_password() configuration method.
	$form = Gaps::form($user, 'gaps_password');
	
	if (Request::POST  === $this->request->method())
	{
		// Load POST and validate.
		if ($form->load($this->request->post()))
		{
			// Save the changed password.
			$form->save();
			// Alternative:
			// $user->save();
		}
	}
	
	// Will automatically show errors if POST request was made but was not valid.
	echo $form;