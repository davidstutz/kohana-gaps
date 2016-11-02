<select name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?>>
    <?php $models = $input->models(); ?>
    <?php foreach ($models as $model): ?>
        <option value="<?php echo $model->id; ?>" <?php if ($input->value() == $model->id) echo "selected"; ?>>
            <?php echo strtr($input->orm, $model->as_array()); ?>
        </option>
    <?php endforeach; ?>
</select>
