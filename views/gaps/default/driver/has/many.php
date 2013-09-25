<span class="field">
	<?php if ($input->label): ?>
		<span class="label">
			<label for="<?php echo $input->field; ?>">
				<?php echo __($input->label); ?>
			</label>
		</span>
	<?php endif; ?>
	<span class="input">
		
		<?php $models = $input->models(); ?>
		<?php foreach ($models as $model): ?>
			<span class="checkbox">
				<label>
                    <input
                        name="<?php echo $input->field; ?>[]"
                        type="checkbox" value="<?php echo $model->id; ?>"
                        <?php if ($input->model()->has($input->field, $model->id) OR (($array = $input->value() AND is_array($array) AND array_search($model->id, $array) !== FALSE))): ?>
                                checked="checked"
                        <?php endif; ?>
                        <?php echo HTML::attributes($input->attributes); ?> />
                     <?php echo strtr($input->orm, $model->as_array()); ?>
                </label>
			</span>
		<?php endforeach; ?>
	</span>
</span>
