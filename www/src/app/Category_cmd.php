<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_cmd extends Model
{
    protected $table = 'category_cmd';
    protected $fillable = ['category_name','syntaxe','id'];
}
