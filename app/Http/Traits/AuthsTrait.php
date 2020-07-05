<?php
namespace App\Http\Traits;
use App\User;

trait  AuthsTrait {

    public function getUserByLoginToken($token)
    {
      $token = explode("-", $token);

      $userId = $token[1];

      return User::where('id' , $userId)->first();

    }

    public function checkPermission($code)
    {

      return User::where('permission' , $code)->admin()->first();

    }
}