<?php
namespace App\Http\Traits;
use App\User;
use Carbon\Carbon;
trait  AuthsTrait {

    public function getUserByLoginToken($token)
    {
      $token = explode("-", $token);

      $loginToken = $token[0];
      $userId = $token[1];

      return User::select('users.*')
        ->leftJoin('user_sessions', 'user_sessions.user_id', '=', 'users.id')
        ->where('users.id' , $userId)->where('user_sessions.expiration', '>', Carbon::now()->format('Y-m-d H:i:s'))->first();

    }

    public function checkPermission($code)
    {

      return User::where('permission' , $code)->admin()->first();

    }
}