<?php

use ntentan\honam\engines\php\helpers\form\Container;
use ntentan\honam\engines\php\helpers\form\Element;

$attributes = $element->getAttributes(Element::SCOPE_WRAPPER);
$id = $element->getId();
if($element->unescape()->getType() === 'ntentan\honam\helpers\form\HiddenField'):?>
    <?= $element->unescape()->render(); ?>
<?php else: ?>
    <div class="form-element <?= $element->hasError() ? 'form-error' : '' ?>" <?php if($id != ''): ?>id="<?= $id ?>_wrapper"<?php endif; ?>>
        <?php
            if(!is_a($element, Container::class) && $element->getRenderLabel())
            {
                echo $this->partial("element_label.tpl.php", array('element' => $element, 'label' => $element->getLabel()));
            }
        ?>  
        <?= $element->render()->unescape() ?>
        <?php if($element->getDescription() != ""): ?>
            <span> <?= $element->getDescription() ?> </span>
        <?php endif; ?>

        <?php if($element->hasError()):
            $errors = $element->getErrors();?>
            <ul>
                <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>