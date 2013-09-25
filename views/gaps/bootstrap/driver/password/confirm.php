<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
	<label class="control-label" for="<?php echo $input->field; ?>">
		<?php echo __($input->label); ?>
	</label>
	<div class="controls">
		<input type="password" value="" name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> />
		<?php if ($input->error()): ?>
			<span class="help-inline"><?php echo $input->error(); ?></span>
		<?php endif; ?>
	</div>
</div>

<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
	<label class="control-label" for="<?php echo $input->field; ?>_confirm">
		<?php echo __('Confirm'); ?>
	</label>
	<div class="controls">
		<input type="password" value="" name="<?php echo $input->field; ?>_confirm" <?php echo HTML::attributes($input->attributes); ?> />
		<?php if ($input->error()): ?>
			<span class="help-inline"><?php echo $input->error(); ?></span>
		<?php endif; ?>
	</div>
</div>