<div class="form-group <?php if ($input->error()) echo 'has-error'; ?>">
    <div class="col-sm-offset-2 col-sm-10">
        <?php if ($input->label): ?>
            <div class="checkbox">
                <label for="<?php echo $input->field; ?>">
                    <input type="checkbox" <?php if ($input->checked() OR $input->value()) echo 'checked="checked"'; ?> name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> /> <?php echo __($input->label); ?>
                    <?php if ($input->error()): ?>
                        <span class="help-inline"><?php echo $input->error(); ?></span>
                    <?php endif; ?>
                </label>
            </div>
        <?php endif; ?>
    </div>
</div>
