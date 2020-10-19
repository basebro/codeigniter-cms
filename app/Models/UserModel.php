<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'users';
  protected $allowedFields = ['name', 'last_name', 'email', 'password', 'roles', 'created_at', 'updated_at'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];




  protected function beforeInsert(array $data)
  {
    $data = $this->passwordHash($data);
    $data['data']['created_at'] = date('Y-m-d H:i:s');
    $data['data']['roles'] = json_encode($data['data']['roles']);

    return $data;
  }

  protected function beforeUpdate(array $data)
  {
    $data = $this->passwordHash($data);
    $data['data']['updated_at'] = date('Y-m-d H:i:s');
    $data['data']['roles'] = json_encode($data['data']['roles']);

    return $data;
  }

  protected function passwordHash(array $data)
  {
    if (isset($data['data']['password']))
      $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

    return $data;
  }

  public function getUserById($id)
  {
    return $this->asArray()
      ->where(['id' => $id])
      ->first();
  }
}
