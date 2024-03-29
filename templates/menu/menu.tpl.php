<?php if(count($items) > 0):?>
    <?php $css_classes = $css_classes->unescape() ?>
    <ul class='<?= implode(' ', $css_classes['menu'] ?? []) ?>' <?php if($alias != ''): ?>id="<?= $alias ?>-menu"<?php endif; ?>>
        <?php foreach($items as $item){
            $params = '';
            foreach($item as $key => $value) {
                if($key == 'url' || $key == 'label' || $key == 'selected' || $key == 'id' || $key == 'fully_matched' || $key == 'children') continue;
                $params .= "$key = '$value' ";
            }
            echo $this->partial( "{$alias}_menu_item", ['params' => $params, 'item' => $item, 'has_links' => $has_links ?? false, 'css_classes' => $css_classes]) ;
        } ?></ul>
<?php endif ?>
