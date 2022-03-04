<?php if($label != ''): ?>
<label for="<?= $element->getAttribute('id') ?>" class="form-label"><?= $label ?><?php if($element->getRequired()): ?><span class="required">*</span><?php endif; ?></label>
<?php endif; ?>
