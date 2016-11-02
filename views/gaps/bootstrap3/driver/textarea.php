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
        <textarea name="<?php echo $input->field; ?>" <?php echo HTML::attributes($attributes); ?>><?php echo $input->value(); ?></textarea>
    </div>
</div>
