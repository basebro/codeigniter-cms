<?= \Config\Services::validation()->listErrors(); ?>

<?php if (session()->get('success')) : ?>
  *<?= session()->get('success') ?>*
  <br><br>
<?php endif; ?>

<form class="" action="/login" method="post">
  <label for="email">Email address</label>
  <input type="text" name="email" id="email" value="<?= set_value('email') ?>"><br>
  <label for="password">Password</label>
  <input type="password" name="password" id="password" value=""><br><br>
  <button type="submit">Login</button><br><br>
  <a href="/register">Don't have an account yet?</a>

</form>