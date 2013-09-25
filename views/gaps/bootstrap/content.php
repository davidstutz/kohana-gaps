<?php foreach ($drivers as $group): ?>
        <span class="control-group">
            <?php foreach ($group as $field => $driver): ?>
                <?php echo $driver->render($theme); ?>
            <?php endforeach; ?>
        </span>
        <div class="clearfix"></div>
<?php endforeach; ?>