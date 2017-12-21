<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = true;

    public function task()
    {
        return $this->belongsTo("App\Task");
    }
}
