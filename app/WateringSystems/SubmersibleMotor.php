<?php

namespace App\WateringSystems;

class SubmersibleMotor extends WateringSystem
{
    public function needProperties()
    {
        return [
            "watering_time" => "Watering time(seconds)",
            "forward_pin" => "Forward pin"
        ];
    }
}
