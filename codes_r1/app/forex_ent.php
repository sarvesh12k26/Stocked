<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class forex_ent extends Model
{
    protected $table='forex_ents';
    public $primaryKey='forex_id';
    public $timestamps = true;
}
