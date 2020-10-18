<h2><?= esc($title); ?></h2>

<?= \Config\Services::validation()->listErrors(); ?>

<form action="/news/update/<?= esc($news['id']); ?>" method="post">
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="input" name="title" value="<?= esc($news['title']); ?>" /><br />

    <label for="body">Text</label>
    <textarea name="body" rows="4" cols="50"><?= esc($news['body']); ?></textarea>
    <br />
    <label for="created_at">Date & Time</label>
    <input type="datetime-local" name="created_at" value="<?= date("Y-m-dTH:i", strtotime(($news['created_at']))); ?>" /><br />
    <!-- <input type="datetime-local" name="created_at" value="2017-06-01T08:30" /><br /> -->

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
    <br>

    <input type="submit" name="submit" value="Update news item" />

</form>

<a href="/news">
    <button>Back</button>
</a>