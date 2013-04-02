<?php if (isset($attributes['class'])): ?>
	<?php $attributes['class'] .= ' form-inline'; ?>
<?php else: ?>
	<?php $attributes['class'] = 'form-inline'; ?>
<?php endif; ?>
<form <?php echo HTML::attributes($attributes); ?>>
