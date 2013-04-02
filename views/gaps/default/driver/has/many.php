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
		<?php foreach ($models as $model): ?>
			<span class="<?php echo Gaps::prefix('checkbox'); ?>">
				<input name="<?php echo $input->field; ?>[]" type="checkbox" value="<?php echo $model->id; ?>" <?php if ($input->model()->has($input->field, $model->id) OR (($array = $input->value()) AND is_array($array) AND array_search($model->id, $array) !== FALSE)) echo 'checked="checked"'; ?> <?php echo HTML::attributes($input->attributes); ?> />
				<label>
					<?php echo strtr($input->orm, $model->as_array()); ?>
				</label>
			</span>
		<?php endforeach; ?>
	</span>
</span>
