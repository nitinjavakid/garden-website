<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $timestamps = false;

    public function plants()
    {
        return $this->hasMany("App\Plant");
    }
}
