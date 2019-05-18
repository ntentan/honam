<li <?= $params ?> id="<?= $id ?>" class='menu-item <?= $item['selected'] ? "menu-selected " . implode(' ', unescape($css_classes)['selected']) : ""; ?><?= " $id " ?><?= $item['fully_matched'] ? ' menu-fully-matched ' . implode(' ', unescape($css_classes)['matched']) : ''?>'><?php 
if($has_links == true):?><a <?php if($item['url'] !== false): ?>href='<?= isset($item["url"]) ? $item["url"] : str_replace(" ", "_", strtolower($item["label"]))?>'<?php endif; ?>><?= $item["label"]?></a><?php 
else: echo $item['label']; endif;?></li>
