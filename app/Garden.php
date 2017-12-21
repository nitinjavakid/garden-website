<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garden extends Model
{
    protected $table = "gardens";
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo("App\User", "user_id");
    }

    public function devices()
    {
        return $this->hasMany("App\Device");
    }
}
