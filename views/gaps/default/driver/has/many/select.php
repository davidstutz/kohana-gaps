<span class="field">
    <?php if ($input->label): ?>
        <span class="label">
            <label for="<?php echo $input->field; ?>">
                <?php echo __($input->label); ?>
            </label>
        </span>
    <?php endif; ?>
    <span class="input">
        
        <?php $models = $input->models(); ?>
        <select multiple="multiple" name="<?php echo $input->field; ?>[]" class="select" <?php echo HTML::attributes($input->attributes); ?>>
            <?php foreach ($models as $model): ?>
                <option value="<?php echo $model->id; ?>" <?php if ($input->model()->has($input->field, $model->id)): ?>selected<?php endif; ?>>
                    <?php echo strtr($input->orm, $model->as_array()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </span>
</span>
