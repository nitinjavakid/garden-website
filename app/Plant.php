<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;

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

    public function events()
    {
        return $this->hasManyThrough("App\Event", "App\Task");
    }
}
