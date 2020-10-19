<!doctype html>
<html>

<head>
    <title>eNube - <?= esc($title); ?></title>
</head>

<body>
    <h1><?= esc($title); ?></h1>
    <?php if (session()->get('isLoggedIn')) : ?>
        <a href="/dashboard">
            Articles
        </a> |
        <a href="/dashboard/profile">
            Profile
        </a> |
        <?php if (session()->get('roles') == json_encode(['ROLE_ADMIN'])) : ?>
            <a href="/dashboard/users/show">
                Manage Users
            </a> |
        <?php endif; ?>
        <a href="/logout">
            Logout
        </a>
        <br>
    <?php endif; ?>