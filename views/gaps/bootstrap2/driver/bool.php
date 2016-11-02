<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
    <div class="controls">
        <?php if ($input->label): ?>
            <label class="checkbox" for="<?php echo $input->field; ?>">
                <input type="checkbox" <?php if ($input->checked() OR $input->value()) echo 'checked="checked"'; ?> name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> /> <?php echo __($input->label); ?>
                <?php if ($input->error()): ?>
                    <span class="help-inline"><?php echo $input->error(); ?></span>
                <?php endif; ?>
            </label>
        <?php endif; ?>
    </div>
</div>
