<?php

namespace App\WateringSystems;

class NoWatering extends WateringSystem
{
    public function needProperties()
    {
        return [];
    }
}
