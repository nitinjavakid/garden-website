<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    public function plant()
    {
        return $this->belongsTo("App\Plant");
    }
}
