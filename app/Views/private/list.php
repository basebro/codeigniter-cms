<?php if (session()->get('success')) : ?>
<br>
    *<?= session()->get('success') ?>*
<?php endif; ?>
<?php if (!empty($news) && is_array($news)) : ?>

    <?php foreach ($news as $news_item) : ?>

        <h3><?= esc($news_item['title']); ?></h3>

        <div class="main">
            <?= esc($news_item['body']); ?>
            <p>Created date: <?= esc($news_item['created_at']); ?></p>
        </div>
        <p>
            <a href="/dashboard/<?= esc($news_item['slug'], 'url'); ?>">View</a>,
            <a href="/dashboard/update/<?= esc($news_item['id'], 'url'); ?>">Edit</a>
            <a href="/dashboard/delete/<?= esc($news_item['id'], 'url'); ?>">Delete</a>,
        </p>

    <?php endforeach; ?>

<?php else : ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>

<a href="/dashboard/create">
    <button>Create</button>
</a>