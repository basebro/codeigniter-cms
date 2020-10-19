<?= \Config\Services::validation()->listErrors(); ?>

<h2>Details</h2>
<p><?= esc($user['name']); ?></p>
<p><?= esc($user['last_name']); ?></p>
<p><?= esc($user['email']); ?></p>
<p><?= esc($user['roles']); ?></p>

<form action="/dashboard/users/delete/<?= esc($user['id']); ?>" method="post">
    <?= csrf_field() ?>
    <input type="submit" name="submit" value="Really delete?" />

</form>
<br>
<a href="/dashboard/users/show">
    <button>Back</button>
</a>