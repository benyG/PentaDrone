<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operationpc extends Model
{
    protected $table = 'operationpc';
    protected $fillable = ['ops_name','description','etat_ops','status'];
    public $timestamps = false;
}
