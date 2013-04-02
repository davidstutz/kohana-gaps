<span class="<?php echo Gaps::prefix('field'); ?>">
	<?php if ($input->label): ?>
		<span class="<?php echo Gaps::prefix('label'); ?>">
			<label for="<?php echo $input->field; ?>">
				<?php echo __($input->label); ?>
			</label>
		</span>
	<?php endif; ?>
	<span class="<?php echo Gaps::prefix('input'); ?>">
		
		<?php $models = $input->models(); ?>
		<select multiple="multiple" name="<?php echo $input->field; ?>[]" class="<?php echo Gaps::prefix('select'); ?> <?php echo $input->attributes; ?>">
			<?php foreach ($models as $model): ?>
				<option value="<?php echo $model->id; ?>" <?php if ($input->model()->has($input->field, $model->id)) echo 'selected'; ?>><?php echo strtr($input->orm, $model->as_array()); ?></option>
			<?php endforeach; ?>
		</select>
	</span>
</span>
