<fieldset <?= $this->partial('element_attributes.tpl.php', array('attributes' => $element->getAttributes())) ?>>
<legend id='<?= $element->getId() ?>_leg' ><?= $element->getLabel() ?> </legend>
<div class='fapi-description'><?= $element->getDescription() ?></div>
