<form class="" action="/" method="post">
  <label for="email">Email address</label>
  <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>"><br>

  <label for="password">Password</label>
  <input type="password" class="form-control" name="password" id="password" value=""><br>

  <button type="submit" class="btn btn-primary">Login</button><br>
  <a href="/register">Don't have an account yet?</a>

</form>