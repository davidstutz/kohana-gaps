<div class="control-group <?php if ($input->error()) echo 'error'; ?>">
	<?php if ($input->label): ?>
		<label class="control-label" for="<?php echo $input->field; ?>">
			<?php echo __($input->label); ?> 
			<?php if ($input->error()): ?>
				<span class="help-inline"><?php echo $input->error(); ?></span>
			<?php endif; ?>
		</label>
	<?php endif; ?>
	<div class="controls">
		<?php foreach ($input->models() as $model): ?>
			<label class="checkbox">
				<input
				    name="<?php echo $input->field; ?>[]"
				    type="checkbox" value="<?php echo $model->id; ?>"
				    <?php if ($input->model()->has($input->field, $model->id) OR (($array = $input->value() AND is_array($array) AND array_search($model->id, $array) !== FALSE))): ?>
				            checked="checked"
				    <?php endif; ?>
				    <?php echo HTML::attributes($input->attributes); ?> />
				 <?php echo strtr($input->orm, $model->as_array()); ?>
			</label>
		<?php endforeach; ?>
	</div>
</div>
