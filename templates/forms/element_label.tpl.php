<?php if($label != ''): ?>
<label class="form-label"><?= $label ?><?php if($element->getRequired()): ?><span class="required">*</span><?php endif; ?></label>
<?php endif; ?>
