<select <?= t("element_attributes.tpl.php", array('attributes' => $element->getAttributes())) ?> >

<?php $options = $element->getOptions();
$selectValue = $element->getValue()->unescape();
foreach($options->unescape() as $value => $label):?>
<option value='<?= $value ?>' <?=($selectValue == $value ? "selected='selected'":"") ?> ><?= $label ?></option>
<?php endforeach; ?>
</select>