<?php if(count($items) > 0):?>
    <ul class='menu <?= implode(' ', unescape($css_classes)['menu']) ?>' <?php if($alias != ''): ?>id="<?= $alias ?>-menu"<?php endif; ?>><?php 
        foreach($items as $item){
            $params = '';
            foreach($item as $key => $value)
            {
                if($key == 'url' || $key == 'label' || $key == 'selected' || $key == 'id' || $key == 'fully_matched') continue;
                $params .= "$key = '$value' ";
            }
            $id = isset($item['id']) ? $item['id'] : preg_replace('~-+~', '-', 'menu-item-' . str_replace("/","-",strtolower($item["url"])));
            echo t( "{$alias}_menu_item", array('params' => $params, 'id' => $id, 'item' => $item, 'has_links' => $has_links, 'css_classes' => $css_classes)) ;
        } ?></ul>
<?php endif ?>
