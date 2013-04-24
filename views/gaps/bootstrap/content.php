<?php foreach ($render as $group => $mixed): ?>
	<?php if (is_array($mixed)): ?>
		<span class="controle-group">
			<?php foreach ($mixed as $field): ?>
				<?php echo $drivers[$field]->render($theme); ?>
			<?php endforeach; ?>
		</span>
		<div class="clearfix"></div>
	<?php elseif(is_string($mixed)): ?>
		<?php echo $drivers[$mixed]->render($theme); ?>
	<?php endif; ?>
<?php endforeach; ?>