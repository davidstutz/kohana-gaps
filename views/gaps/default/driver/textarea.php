<span class="field">
	<?php if ($input->label): ?>
		<span class="label">
			<label for="<?php echo $input->field; ?>">
				<?php echo __($input->label); ?>
			</label>
		</span>
	<?php endif; ?>
	<span class="input">
		<textarea name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?>><?php echo $input->value(); ?></textarea>
	</span>
</span>
