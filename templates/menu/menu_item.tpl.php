<li <?= $params ?>
    <?php
        $classString = trim(($item['selected'] ? 'menu-selected ' : '')
            . ($item['fully_matched'] ? 'menu-fully-matched ' : '')
        );
        if ($classString != '') { echo " class=\"$classString\""; }
    ?>>
    <?php if ($has_links == true) : ?>
        <a <?php if ($item['url'] !== false) : ?>href='<?= $prefix ?><?= isset($item["url"]) ? $item["url"] : str_replace(" ", "_", strtolower($item["label"])) ?>' <?php endif; ?>>
            <?= $item["label"] ?>
        </a>
    <?php else : echo $item['label']; endif; ?>
</li>
