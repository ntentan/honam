<?php 
$attributes = $element->getAttributes(\ntentan\honam\helpers\form\Element::SCOPE_WRAPPER);
$id = $element->getId();
if($element->unescape()->getType() === 'ntentan\honam\helpers\form\HiddenField'):?>
    <?= $element->unescape()->render(); ?>
<?php else: ?>
    <div class="form-element-div" <?php if($id != ''): ?>id="<?= $id ?>_wrapper"<?php endif; ?> <?= t("element_attributes.tpl.php", array('attributes' => $attributes)) ?>>
        <?php
            if(!$element->isContainer() && $element->getRenderLabel())
            {
                echo t("element_label.tpl.php", array('element' => $element, 'label' => $element->getLabel()));
            }
        ?>  
        <?= $element->render()->unescape() ?>
        <?php if($element->getDescription() != ""): ?>
            <div <?php if($id!=""): ?>id="<?= $id ?>_desc"<?php endif; ?> class='form-description'> <?= $element->getDescription() ?> </div>
        <?php endif; ?>

        <?php if($element->hasError()):
            $errors = $element->getErrors();?>
            <?php if(is_array($errors) || is_a($errors, '\Iterator')): ?>
                <div class='form-errors'><ul>
                    <?php foreach($errors as $error): ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul></div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>