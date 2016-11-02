<span class="field">
    <?php if ($input->label): ?>
        <span class="label">
            <label for="<?php echo $input->field; ?>">
                <?php echo __($input->label); ?>
            </label>
        </span>
    <?php endif; ?>
    <span class="input">
        <select name="<?php echo $input->field; ?>" class="select" <?php echo HTML::attributes($input->attributes); ?>>
            <?php foreach ($input->models() as $model): ?>
                <option value="<?php echo $model->id; ?>" <?php if ($input->value() == $model->id) echo "selected"; ?>>
                    <?php echo strtr($input->orm, $model->as_array()); ?>
                </option>
            <?php endforeach; ?>
            
        </select>
    </span>
</span>
