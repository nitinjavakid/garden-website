<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WateringSystems\WateringSystem;

class Task extends Model
{
    public $timestamps = false;

    public function plant()
    {
        return $this->belongsTo("App\Plant");
    }

    public function events()
    {
        return $this->hasMany("App\Event");
    }

    public function getWateringSystemAttribute()
    {
        return WateringSystem::deserialize($this->data);
    }

    public function getWateringSystemIndexAttribute()
    {
        $class = get_class(WateringSystem::deserialize($this->data));
        $idx = -1;
        foreach(\App\WateringSystems\WateringSystem::$classes as $key => $value)
        {
            $idx++;
            if(substr($key, 1) == $class)
            {
                return $idx;
            }
        }
        return $idx;
    }

    public function setWateringSystemIndexAttribute($idx_val)
    {
        $idx = -1;
        foreach(\App\WateringSystems\WateringSystem::$classes as $key => $value)
        {
            $idx++;
            if($idx_val == $idx)
            {
                $this->setWateringSystemAttribute(new $key);
            }
        }
    }

    public function setWateringSystemAttribute($value)
    {
        $this->data = $value->serialize();
        print($this->data);
    }
}
