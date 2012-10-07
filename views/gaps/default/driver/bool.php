<span class="<?php echo Gaps::prefix('field'); ?>">
	<span class="<?php echo Gaps::prefix('label'); ?>">
		<span class="<?php echo Gaps::prefix('input'); ?>">
			<input type="checkbox" <?php if ($input->checked()) echo 'checked="checked"'; ?> name="<?php echo $input->field(); ?>" <?php echo HTML::attributes($input->attributes()); ?> />
		</span>
		<?php if ($input->label()): ?>
			<label for="<?php echo $input->field(); ?>">
				<?php echo __($input->label()); ?>
			</label>
		<?php endif; ?>
	</span>
</span>
