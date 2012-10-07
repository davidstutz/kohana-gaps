<?php echo View::factory('gaps/' . $theme . '/open', array('attributes' => $attributes)); ?>
	<?php echo View::factory('gaps/' . $theme . '/content', array('render' => $render, 'drivers' => $drivers, 'errors' => $errors)); ?>
	<?php echo View::factory('gaps/' . $theme . '/submit'); ?>
<?php echo View::factory('gaps/' . $theme . '/close'); ?>