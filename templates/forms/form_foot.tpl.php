<?php if($show_submit): ?>
<div class="form-submit-area"><?php 
foreach($submit_values as $submitValue)
{
    if(is_array($submitValue->u()))
    {
        $submitValue = $submitValue?("value=\"{$submitValue['value']}\" name=\"{$submitValue['name']}\" id=\"{$submitValue['id']}\""):"";
    }
    else
    {
        $submitValue = $submitValue?("value=\"$submitValue\""):"";
    }
    echo sprintf('<input class="form-submit" type="submit" %s />',$submitValue);
}
?></div><?php endif; ?></form>