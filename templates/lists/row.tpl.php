<tr><?php
foreach($row->unescape() as $index => $column)
{
    $cell_template = $cell_templates[$index] == null ?
    $default_cell_template : $cell_templates[$index];
    echo $this->partial($cell_template, array("column"=>$column,"variables"=>$variables));
}
?></tr>