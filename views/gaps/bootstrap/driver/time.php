<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
	<?php if ($input->label): ?>
		<label class="control-label" for="<?php echo $input->field; ?>">
			<?php echo __($input->label); ?>
		</label>
	<?php endif; ?>
	<div class="controls">
		<div class="input-append bootstrap-timepicker">
			<input type="text" value="<?php echo $input->value(); ?>" name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> />
			<span class="add-on"><i class="icon-time"></i></span>
		</div>
		<?php if ($input->error()): ?>
			<span class="help-inline"><?php echo $input->error(); ?></span>
		<?php endif; ?>
	</div>
</div>