<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agent';
    protected $fillable = ['ip_agent','Commentaires','file_conf','operationpc_fk'];
}
