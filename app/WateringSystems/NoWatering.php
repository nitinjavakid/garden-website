<?php

namespace App\WateringSystems;

class NoWatering extends WateringSystem
{
    public function needProperties()
    {
        return [];
    }

    public function getInstruction()
    {
        return "";
    }

    public function getWateringTime()
    {
        return 0;
    }
}
