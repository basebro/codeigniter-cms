<?php if (!empty($news) && is_array($news)) : ?>

    <?php foreach ($news as $news_item) : ?>

        <h3><?= esc($news_item['title']); ?></h3>

        <div class="main">
            <?= esc($news_item['body']); ?>
            <p>Date: <?= esc($news_item['created_at']); ?></p>
        </div>
        <p>
            <a href="/<?= esc($news_item['slug'], 'url'); ?>">View</a>,
        </p>

    <?php endforeach; ?>

<?php else : ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>