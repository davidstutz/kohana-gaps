<?php if (!empty($errors)): ?>
	<?php echo strtr(Kohana::$config->load('gaps.error'), array(':errors' => implode('<br />', $errors))); ?>
<?php endif; ?>
<?php foreach ($render as $group => $mixed): ?>
	<?php if (is_array($mixed)): ?>
		<span class="<?php echo Gaps::prefix('group'); ?>">
			<?php foreach ($mixed as $field): ?>
				<?php echo $drivers[$field]->render($theme); ?>
			<?php endforeach; ?>
		</span>
		<span class="<?php echo Gaps::prefix('clear'); ?>"></span>
	<?php elseif(is_string($mixed)): ?>
		<?php echo $drivers[$mixed]->render($theme); ?>
	<?php endif; ?>
<?php endforeach; ?>