<?php if(count($items) > 0):?>
    <ul <?php if($alias != ''): ?>id="<?= $alias ?>-menu"<?php endif; ?>>
        <?php foreach($items as $item){
            $params = '';
            foreach($item as $key => $value) {
                if($key == 'url' || $key == 'label' || $key == 'selected' || $key == 'id' || $key == 'fully_matched' || $key == 'children') continue;
                $params .= "$key = '$value' ";
            }
            echo $this->partial( "{$alias}_menu_item", ['params' => $params, 'item' => $item, 'has_links' => $has_links ?? false, 'css_classes' => $css_classes, 'prefix'=>$prefix]) ;
        } ?></ul>
<?php endif ?>
