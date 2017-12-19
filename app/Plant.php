<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    public $timestamps = false;
    public function device()
    {
        return $this->belongsTo("App\Device");
    }

    public function tasks()
    {
        return $this->hasMany("App\Task");
    }
}
