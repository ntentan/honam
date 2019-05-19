<?php  ?>
<table class='item-table'>
    <?php if(count($headers->unescape()) > 0): ?>
    <thead>
        <tr>
            <?php foreach($headers as $header):?>
            <th><?= $header ?></th>
            <?php endforeach;?>
        </tr>
    </thead>
    <?php endif; ?>
    <tbody><?php 
        foreach($data as $row)
        {
            echo $this->partial($row_template, array('row' => $row, 'cell_templates'=> $cell_templates, 'default_cell_template'=>$default_cell_template, 'variables'=>$variables));
        }
    ?></tbody>
</table>
