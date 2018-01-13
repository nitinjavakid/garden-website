<?php

namespace App\WateringSystems;

class SubmersibleMotor extends WateringSystem
{
    public function needProperties()
    {
        return [
            "watering_time" => "Watering time(seconds)",
            "forward_pin" => "Forward pin",
            "reverse_pin" => "Reverse pin"
        ];
    }

    public function getInstruction()
    {
        return $this->getProperty("forward_pin")
            . "," . $this->getProperty("reverse_pin")
            . "," . $this->getProperty("watering_time");
    }

    public function getWateringTime()
    {
        return (int) $this->getProperty("watering_time");
    }
}
