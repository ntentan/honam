<textarea <?= $this->partial('element_attributes.tpl.php', array('attributes' => $element->getAttributes())) ?>><?= $element->getValue() ?></textarea>