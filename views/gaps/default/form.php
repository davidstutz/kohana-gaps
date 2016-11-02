<?php echo View::factory('gaps/open', array('attributes' => $attributes)); ?>
    <?php echo View::factory('gaps/content', array('render' => $render, 'drivers' => $drivers, 'errors' => $errors)); ?>
    <?php echo View::factory('gaps/submit'); ?>
<?php echo View::factory('gaps/close'); ?>