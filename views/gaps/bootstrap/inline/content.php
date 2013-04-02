<?php foreach ($render as $group => $mixed): ?>
	<?php if (is_array($mixed)): ?>
		<?php foreach ($mixed as $field): ?>
			<?php echo $drivers[$field]->render($theme); ?>
		<?php endforeach; ?>
	<?php elseif(is_string($mixed)): ?>
		<?php echo $drivers[$mixed]->render($theme); ?>
	<?php endif; ?>
<?php endforeach; ?>