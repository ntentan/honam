<li <?= $params ?> id="<?= $id ?>" class='menu-item <?= $item['selected'] ? "menu-selected " : ""; ?><?= $id ?><?= $item['fully_matched'] ? ' menu-fully-matched ' : ''?>'><?php 
if($has_links == true):?><a <?php if($item['url'] !== false): ?>href='<?= isset($item["url"]) ? $item["url"] : str_replace(" ", "_", strtolower($item["label"]))?>'<?php endif; ?>><?= $item["label"]?></a><?php 
else: echo $item['label']; endif;?></li>
