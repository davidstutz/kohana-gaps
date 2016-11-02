<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
    <?php if ($input->label): ?>
        <label class="control-label" for="<?php echo $input->field; ?>">
            <?php echo __($input->label); ?>
        </label>
    <?php endif; ?>
    <div class="controls">
        <select multiple="multiple" name="<?php echo $input->field; ?>[]" <?php echo HTML::attributes($input->attributes); ?>>
            <?php foreach ($input->models() as $model): ?>
                <option value="<?php echo $model->id; ?>" <?php if ($input->model()->has($input->field, $model->id)): ?>selected<?php endif; ?>>
                    <?php echo strtr($input->orm, $model->as_array()); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if ($input->error()): ?>
            <span class="help-inline"><?php echo $input->error(); ?></span>
        <?php endif; ?>
    </div>
</div>
