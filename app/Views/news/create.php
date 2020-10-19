<h2><?= esc($title); ?></h2>

<?= \Config\Services::validation()->listErrors(); ?>

<form action="/dashboard/create" method="post">
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="input" name="title" /><br />

    <label for="body">Text</label>
    <textarea name="body" rows="4" cols="50"></textarea><br />
    
    <label for="visibility">Visibility</label>

    <select name="visibility">
        <option value="">Choose an option</option>
        <option value="public">
            public</option>
        <option value="private">
            private</option>
    </select>
    <br>
    
    <label for="status">status</label>

    <select name="status">
        <option value="">Choose an option</option>
        <option value="published">
        published</option>
        <option value="unpublished">
        unpublished</option>
    </select>
    <br>

    <input type="submit" name="submit" value="Create news article" />

</form>


<a href="/dashboard">
    <button>Back</button>
</a>