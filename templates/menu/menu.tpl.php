<?php if(count($items) > 0):?>
    <?php $css_classes = $css_classes->unescape() ?>
    <ul class='menu <?= implode(' ', $css_classes['menu'] ?? []) ?>' <?php if($alias != ''): ?>id="<?= $alias ?>-menu"<?php endif; ?>><?php
        foreach($items as $item){
            $params = '';
            foreach($item as $key => $value)
            {
                if($key == 'url' || $key == 'label' || $key == 'selected' || $key == 'id' || $key == 'fully_matched' || $key == 'children') continue;
                $params .= "$key = '$value' ";
            }
            $id = isset($item['id']) ? $item['id'] : preg_replace('~-+~', '-', 'menu-item-' . str_replace("/","-",strtolower($item["url"])));
            echo $this->partial( "{$alias}_menu_item", ['params' => $params, 'id' => $id, 'item' => $item, 'has_links' => $has_links ?? false, 'css_classes' => $css_classes]) ;
        } ?></ul>
<?php endif ?>
