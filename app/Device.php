<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $timestamps = false;

    public function garden()
    {
        return $this->belongsTo("App\Garden", "garden_id");
    }

    public function plants()
    {
        return $this->hasMany("App\Plant");
    }
}
