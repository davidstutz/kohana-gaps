<span class="<?php echo Gaps::prefix('field'); ?>">
	<?php if ($input->label()): ?>
		<span class="<?php echo Gaps::prefix('label'); ?>">
			<label for="<?php echo $input->field(); ?>">
				<?php echo __($input->label()); ?>
			</label>
		</span>
	<?php endif; ?>
	<span class="<?php echo Gaps::prefix('input'); ?>">
		<input type="text" value="<?php echo $input->value(); ?>" name="<?php echo $input->field(); ?>" <?php echo HTML::attributes($input->attributes()); ?> />
	</span>
</span>
