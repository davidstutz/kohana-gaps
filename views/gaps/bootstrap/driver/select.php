<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
	<?php if ($input->label): ?>
		<label class="control-label" for="<?php echo $input->field; ?>">
			<?php echo __($input->label); ?>
		</label>
	<?php endif; ?>
	<div class="controls">
		<select name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?>>
			<?php foreach ($input->options as $value => $option): ?>
				<option value="<?php echo $value; ?>" <?php if ($input->value() == $value) echo 'selected="selected"'; ?>><?php echo $option; ?></option>
			<?php endforeach; ?>
		</select>
		<?php if ($input->error()): ?>
			<span class="help-inline"><?php echo $input->error(); ?></span>
		<?php endif; ?>
	</div>
</div>
