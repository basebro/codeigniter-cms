<?= \Config\Services::validation()->listErrors(); ?>
<br>
<form action="/dashboard/update/<?= esc($news['id']); ?>" method="post">
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="input" name="title" value="<?= esc($news['title']); ?>" /><br />

    <label for="body">Text</label>
    <textarea name="body" rows="4" cols="50"><?= esc($news['body']); ?></textarea>
    <br />

    <label for="visibility">Visibility</label>

    <select name="visibility">
        <option value="">Choose an option</option>
        <option value="public" <?php if ($news['visibility'] == 'public') : ?> selected <?php endif ?>>
            public</option>
        <option value="private" <?php if ($news['visibility'] == 'private') : ?> selected <?php endif ?>>
            private</option>
    </select>
    <br>
    <label for="status">status</label>

    <select name="status">
        <option value="">Choose an option</option>
        <option value="published" <?php if ($news['status'] == 'published') : ?> selected <?php endif ?>>
            published</option>
        <option value="unpublished" <?php if ($news['status'] == 'unpublished') : ?> selected <?php endif ?>>
            unpublished</option>
    </select>
    <br><br>

    <input type="submit" name="submit" value="Update news article" />

</form>
<br>
<a href="/dashboard">
    <button>Back</button>
</a>