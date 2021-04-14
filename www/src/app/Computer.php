<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $table = 'computer';
    protected $fillable = ['pc','hostname','ip','domain','ops_linked','obs'];
}
