<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_ent extends Model
{
    protected $table='stock_ents';
    public $primaryKey='stock_id';
    public $timestamps = true;
}
