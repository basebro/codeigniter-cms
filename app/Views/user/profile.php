<?= \Config\Services::validation()->listErrors(); ?>
<h2>Details</h2>
<?php if (session()->get('success')) : ?>
  *<?= session()->get('success') ?>*
  <br>
<?php endif; ?>
<br>
<form action="/dashboard/profile" method="post">

  <label for="name"> Name</label>
  <input type="text" name="name" id="name" value="<?= set_value('name', $user['name']) ?>"> <br>

  <label for="lastname">Last Name</label>
  <input type="text" name="last_name" id="last_name" value="<?= set_value('last_name', $user['last_name']) ?>"> <br>

  <label for="email">Email address</label>
  <input type="text" name="email" id="email" readonly value="<?= $user['email'] ?>"> <br>

  <label for="password">Password</label>
  <input type="password" name="password" id="password" value=""> <br>

  <label for="password_confirm">Confirm Password</label>
  <input type="password" name="password_confirm" id="password_confirm" value=""> <br>

  <label for="roles">Roles</label>
  <input type="roles" name="roles[]" id="roles" readonly value="<?= set_value('roles', $user['roles']) ?>"> <br>
  <br>
  <button type="submit">Update</button> <br>


</form>
<br>

<a href="/dashboard">
  <button>Back</button>
</a>