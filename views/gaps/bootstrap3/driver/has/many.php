<div class="form-group <?php if ($input->error()) echo 'has-error'; ?>">
    <?php if ($input->label): ?>
        <label class="col-sm-2" for="<?php echo $input->field; ?>">
            <?php echo __($input->label); ?> 
        </label>
        <div class="col-sm-10">
    <?php else: ?>
        <div class="col-sm-offset-2 col-sm-10">
    <?php endif; ?>
        <div class="checkbox">
            <?php foreach ($input->models() as $model): ?>
                <label>
                    <input
                        name="<?php echo $input->field; ?>[]"
                        type="checkbox" value="<?php echo $model->id; ?>"
                        <?php if ($input->model()->has($input->field, $model->id) OR (($array = $input->value() AND is_array($array) AND array_search($model->id, $array) !== FALSE))): ?>
                                checked="checked"
                        <?php endif; ?>
                        <?php echo HTML::attributes($input->attributes); ?> />
                     <?php echo strtr($input->orm, $model->as_array()); ?>
                </label><br>
            <?php endforeach; ?>
        </div>
    </div>
</div>
