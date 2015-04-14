<fieldset <?= t('element_attributes.tpl.php', array('attributes' => $element->getAttributes())) ?>>
<legend id='<?= $element->id() ?>_leg' ><?= $element->getLabel() ?> </legend>
<div class='fapi-description'><?= $element->getDescription() ?></div>
