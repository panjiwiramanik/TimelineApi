<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'user';

    protected $fillable = [
        'name', 'email', 'username', 'password'
    ];

    public static $rules_add = [
        'name' => 'required',
        'email' => 'email|required',
        'username' => 'required',
        'password' => 'required'
    ];

}