<?php 
$attributes = $element->getAttributes(\ntentan\honam\helpers\form\api\Element::SCOPE_WRAPPER);
if($element->getType() === 'ntentan\honam\helpers\form\api\HiddenField'):?>
    <?= $element->render(); ?>
<?php else: ?>
    <div class="form-element-div" <?php if($element->id() != ''): ?>id="<?= $element->id() ?>_wrapper"<?php endif; ?> <?= t("element_attributes.tpl.php", array('attributes' => $attributes)) ?>>
        <?php
            if(!$element->isContainer() && $element->getRenderLabel())
            {
                echo t("element_label.tpl.php", array('element' => $element, 'label' => $element->getLabel()));
            }
        ?>  
        <?= $element->render() ?>
        <?php if($element->getDescription() != ""): ?>
            <div <?=($element->id()==""?"":"id='".$element->id()."_desc'") ?> class='form-description'> <?= $element->getDescription() ?> </div>
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