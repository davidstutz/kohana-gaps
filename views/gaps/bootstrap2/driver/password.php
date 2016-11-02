<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
    <?php if ($input->label): ?>
        <label class="control-label" for="<?php echo $input->field; ?>">
            <?php echo __($input->label); ?>
        </label>
    <?php endif; ?>
    <div class="controls">
        <input type="password" value="" name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> />
    </div>
    <?php if ($input->error()): ?>
        <span class="help-inline"><?php echo $input->error(); ?></span>
    <?php endif; ?>
</div>