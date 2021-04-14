<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    protected $table = 'user_roles';
    protected $primaryKey = 'user_id';
    protected $fillable = ['roles_name','permission_name'];
}
