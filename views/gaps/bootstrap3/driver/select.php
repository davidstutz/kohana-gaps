<div class="form-group <?php if ($input->error()) echo 'has-error'; ?>">
    <?php if ($input->label): ?>
        <label class="col-sm-2" for="<?php echo $input->field; ?>">
            <?php echo __($input->label); ?>
        </label>
        <div class="col-sm-10">
    <?php else: ?>
        <div class="col-sm-offset-2 col-sm-10">
    <?php endif; ?>
        <?php 
            $attributes = $input->attributes;
            if (isset($attributes['class'])) {
                $attributes['class'] .= ' form-control';
            }
            else {
                $attributes['class'] = 'form-control';
            }
        ?>
        <select name="<?php echo $input->field; ?>" <?php echo HTML::attributes($attributes); ?>>
            <?php foreach ($input->options as $value => $option): ?>
                <option value="<?php echo $value; ?>" <?php if ($input->value() == $value) echo 'selected="selected"'; ?>><?php echo $option; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
