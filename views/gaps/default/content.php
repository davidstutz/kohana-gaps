<?php foreach ($errors as $error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endforeach; ?>

<?php foreach ($drivers as $group): ?>
    <span class="group">
        <?php foreach ($group as $field => $driver): ?>
            <?php echo $driver->render($theme); ?>
        <?php endforeach; ?>
    </span>
    <span class="clear"></span>
<?php endforeach; ?>