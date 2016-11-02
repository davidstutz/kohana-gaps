<span class="field">
    <?php if ($input->label): ?>
        <span class="label">
            <label for="<?php echo $input->field; ?>">
                <?php echo __($input->label); ?>
            </label>
        </span>
    <?php endif; ?>
    <span class="input">
        <select name="<?php echo $input->field; ?>" <?php echo HTML::attributes($input->attributes); ?>>
            <?php foreach ($input->options as $value => $option): ?>
                <option value="<?php echo $value; ?>" <?php if ($input->value() == $value) echo 'selected="selected"'; ?>><?php echo $option; ?></option>
            <?php endforeach; ?>
        </select>
    </span>
</span>
