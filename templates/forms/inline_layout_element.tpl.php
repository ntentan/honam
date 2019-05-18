<?php 
$attributes = $element->getAttributes(\ntentan\honam\helpers\form\Element::SCOPE_WRAPPER);
$id = $element->getId();
if($element->unescape()->getType() === 'ntentan\honam\helpers\form\HiddenField'):?>
    <?= $element->unescape()->render(); ?>
<?php else: ?>
    <div class="form-element <?= $element->hasError() ? 'form-error' : '' ?>" <?php if($id != ''): ?>id="<?= $id ?>_wrapper"<?php endif; ?>>
        <?php
            if(!$element->isContainer() && $element->getRenderLabel())
            {
                echo t("element_label.tpl.php", array('element' => $element, 'label' => $element->getLabel()));
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