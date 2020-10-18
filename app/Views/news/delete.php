<h2><?= esc($title); ?></h2>

<?= \Config\Services::validation()->listErrors(); ?>
<p><?= esc($news['body']); ?></p>
<?= date("d-m-Y H:i:s", strtotime(($news['created_at']))); ?>

<form action="/news/delete/<?= esc($news['id']); ?>" method="post">
    <?= csrf_field() ?>
    <input type="submit" name="submit" value="Really delete?" />

</form>
<a href="/news">
    <button>Back</button>
</a>