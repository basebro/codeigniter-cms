<h2><?= esc($title); ?></h2>

<?= \Config\Services::validation()->listErrors(); ?>
<p><?= esc($user['email']); ?></p>

<form action="/dashboard/users/delete/<?= esc($user['id']); ?>" method="post">
    <?= csrf_field() ?>
    <input type="submit" name="submit" value="Really delete?" />

</form>
<br>
<a href="/dashboard/users/show">
    <button>Back</button>
</a>