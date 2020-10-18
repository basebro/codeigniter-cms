<form class="" action="/register" method="post">

  <label for="firstname">First Name</label>
  <input type="text" class="form-control" name="firstname" id="firstname" value="<?= set_value('firstname') ?>"> <br>

  <label for="lastname">Last Name</label>
  <input type="text" class="form-control" name="lastname" id="lastname" value="<?= set_value('lastname') ?>"> <br>

  <label for="email">Email address</label>
  <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>"> <br>

  <label for="password">Password</label>
  <input type="password" class="form-control" name="password" id="password" value=""> <br>

  <label for="password_confirm">Confirm Password</label>
  <input type="password" class="form-control" name="password_confirm" id="password_confirm" value=""> <br>


  <button type="submit" class="btn btn-primary">Register</button> <br>

  <a href="/login">Already have an account</a>

</form>