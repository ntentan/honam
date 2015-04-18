<div class='item-pages-list'>
    <?php foreach ($pages as $page):?>
    <a <?= $page['selected'] ? "class='selected'" : "" ?> href='<?= $page["link"] ?>'><?= $page["label"] ?></a>
    <?php endforeach;?>
</div>