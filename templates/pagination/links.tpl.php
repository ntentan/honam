<ul class='pagination'><?php 
    foreach ($links as $link):
?><li><a <?= $link['selected'] ? "class='selected'" : "" ?> href='<?= $link["link"] ?>'><?= $link["label"] ?></a></li><?php endforeach ;?>
</ul>