<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Auth;

class mMember extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable,
        CanResetPassword;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    protected $fillable = ['id','full_name', 'password','username','created_at', 'updated_at', 'deleted_at'];

}
