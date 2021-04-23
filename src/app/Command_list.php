<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command_list extends Model
{
    protected $table = 'command_list';
    protected $primaryKey = 'id_listcmd';
    protected $fillable = ['name','name_cmd','param','description','category_fk'];

}
