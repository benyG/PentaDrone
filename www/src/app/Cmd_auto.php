<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cmd_auto extends Model
{
    protected $table = 'cmd_auto';
    protected $primaryKey = 'id_cmdauto';
    protected $fillable = ['cmd_auto','operationpc_cmd_fk','ordre'];
}
