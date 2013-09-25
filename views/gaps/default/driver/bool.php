<span class="field">
	<span class="label">
		<span class="input">
			<input type="checkbox" <?php if ($input->checked() OR $input->value()) echo 'checked="checked"'; ?> name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?> />
		</span>
		<?php if ($input->label): ?>
			<label for="<?php echo $input->field; ?>">
				<?php echo __($input->label); ?>
			</label>
		<?php endif; ?>
	</span>
</span>
