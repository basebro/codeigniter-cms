<h2><?= esc($news['title']); ?></h2>
<p><?= esc($news['body']); ?></p>
<?= date("d-m-Y H:i:s", strtotime(($news['created_at']))); ?>

<a href="/news">
    <button>Back</button>
</a>