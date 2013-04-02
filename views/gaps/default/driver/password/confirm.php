<span class="<?php echo Gaps::prefix('field'); ?>">
	<span class="<?php echo Gaps::prefix('label'); ?>">
		<label for="<?php echo $input->field; ?>">
			<?php echo __($input->label); ?>
		</label>
	</span>
	<span class="<?php echo Gaps::prefix('input'); ?>">
		<input type="password" value="" name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> />
	</span>
</span>
<span class="<?php echo Gaps::prefix('field'); ?>">
	<span class="<?php echo Gaps::prefix('label'); ?>">
		<label for="<?php echo $input->field; ?>_confirm">
			<?php echo __('Confirm'); ?>
		</label>
	</span>
	<span class="<?php echo Gaps::prefix('input'); ?>">
		<input type="password" value="" name="<?php echo $input->field; ?>_confirm" <?php echo HTML::attributes($input->attributes); ?> />
	</span>
</span>