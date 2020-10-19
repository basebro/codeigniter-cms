<?php if (session()->get('success')) : ?>
    <br>
    *<?= session()->get('success') ?>*
    <br>
<?php endif; ?>
<br><br>
<?php if (!empty($users) && is_array($users)) : ?>

    <table style="width:100%">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Last_name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Created_at</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $users_item) : ?>
            <tr>
                <td>
                    <p><?= esc($users_item['id']); ?></p>
                </td>
                <td>
                    <p><?= esc($users_item['name']); ?></p>
                </td>
                <td>
                    <p><?= esc($users_item['last_name']); ?></p>
                </td>
                <td>
                    <p><?= esc($users_item['email']); ?></p>
                </td>
                <td>
                    <p><?= esc($users_item['roles']); ?></p>
                </td>
                <td>
                    <p>Date: <?= esc($users_item['created_at']); ?></p>
                </td>
                <td>
                    <p>
                        <a href="/dashboard/users/edit/<?= esc($users_item['id'], 'url'); ?>">Edit</a> |
                        <a href="/dashboard/users/delete/<?= esc($users_item['id'], 'url'); ?>">Delete</a>
                    </p>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php else : ?>

    <h3>No Users</h3>

    <p>Unable to find any user.</p>

<?php endif ?>

<a href="/dashboard/users/create">
    <button>Create User</button>
</a>