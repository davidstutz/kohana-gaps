<?php 
    $attributes = $input->attributes;
    if (isset($attributes['class'])) {
        $attributes['class'] .= ' form-control';
    }
    else {
        $attributes['class'] = 'form-control';
    }
?>

<div class="form-group <?php if ($input->error()) echo 'has-error'; ?>">
    <?php if ($input->label): ?>
        <label class="col-sm-2" for="<?php echo $input->field; ?>">
            <?php echo __($input->label); ?>
        </label>
        <div class="col-sm-10">
    <?php else: ?>
        <div class="col-sm-offset-2 col-sm-10">
    <?php endif; ?>
        <input type="password" value="" name="<?php echo $input->field; ?>" <?php echo HTML::attributes($attributes); ?> />
    </div>
</div>

<div class="form-group <?php if ($input->error()) echo 'error'; ?>">
    <label class="col-sm-2" for="<?php echo $input->field; ?>_confirm">
        <?php echo __('Confirm'); ?>
    </label>
    <div class="col-sm-10">
        <input type="password" value="" name="<?php echo $input->field; ?>_confirm" <?php echo HTML::attributes($attributes); ?> />
    </div>
</div>