<?php if (isset($attributes['class'])): ?>
	<?php $attributes['class'] .= ' form-horizontal'; ?>
<?php else: ?>
	<?php $attributes['class'] = 'form-horizontal'; ?>
<?php endif; ?>
<form <?php echo HTML::attributes($attributes); ?>>
