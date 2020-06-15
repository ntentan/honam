<tr><?php
foreach($row->unescape() as $index => $column)
{
    $cell_template = $cell_templates[$index] ?? $default_cell_template;
    echo $this->partial($cell_template, array("column"=>$column,"variables"=>$variables));
}
?></tr>