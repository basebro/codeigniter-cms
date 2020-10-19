<?= \Config\Services::validation()->listErrors(); ?>

<form class="" action="/dashboard/users/create" method="post">

  <label for="name"> Name</label>
  <input type="text" name="name" id="name" value="<?= set_value('name') ?>"> <br>

  <label for="lastname">Last Name</label>
  <input type="text" name="last_name" id="last_name" value="<?= set_value('last_name') ?>"> <br>

  <label for="email">Email address</label>
  <input type="text" name="email" id="email" value="<?= set_value('email') ?>"> <br>

  <label for="password">Password</label>
  <input type="password" name="password" id="password" value=""> <br>

  <label for="password_confirm">Confirm Password</label>
  <input type="password" name="password_confirm" id="password_confirm" value=""> <br>

  <label for="roles">Roles</label>
  <input type="roles" name="roles[]" id="roles" value="" placeholder="ROLE_ADMIN, ROLE_USER"> <br>


  <button type="submit">Create</button> <br>


</form>