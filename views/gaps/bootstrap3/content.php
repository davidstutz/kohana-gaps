<?php foreach ($drivers as $group): ?>
    <?php foreach ($group as $field => $driver): ?>
        <?php echo $driver->render($theme); ?>
    <?php endforeach; ?>
<?php endforeach; ?>