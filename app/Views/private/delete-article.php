<h2><?= esc($title); ?></h2>

<?= \Config\Services::validation()->listErrors(); ?>
<p><?= esc($news['body']); ?></p>

<form action="/dashboard/delete/<?= esc($news['id']); ?>" method="post">
    <?= csrf_field() ?>
    <input type="submit" name="submit" value="Really delete?" />
</form>
<br>
<a href="/dashboard">
    <button>Back</button>
</a>