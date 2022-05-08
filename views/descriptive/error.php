<?php
if (isset($items)) :
?>
    <div class="col" style="font-weight:bold">
        <?php foreach ($items['type'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['company_name'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['position'] ?? [] as $item) : ?>
            <div class="item"> <?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['position_description'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['salary'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['starts_at'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['ends_at'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>

        <?php foreach ($items['post_at'] ?? [] as $item) : ?>
            <div class="item"><?= $item; ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>