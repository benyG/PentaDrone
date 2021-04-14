<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $table = 'commands';
    protected $fillable = ['pc','cmd','result','ok'];
    public $timestamps = false;
}
