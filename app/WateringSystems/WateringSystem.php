<?php

namespace App\WateringSystems;

abstract class WateringSystem
{
    abstract protected function needProperties();

    abstract protected function getInstruction();

    abstract protected function getWateringTime();

    public static $classes = [
        "\App\WateringSystems\NoWatering" => "Dont Water",
        "\App\WateringSystems\SubmersibleMotor" => "Submersible Motor",
    ];

    private $values = [];

    public function getProperty($name)
    {
        if(isset($this->values[$name]))
            return $this->values[$name];
        else
            return "";
    }

    public function setProperty($name, $value)
    {
        $this->values[$name] = $value;
    }

    public function serialize()
    {
        return json_encode([
            "name" => get_class($this),
            "values" => $this->values
        ]);
    }

    public static function deserialize($data)
    {
        $json = json_decode($data, true);
        $waterSystem = null;
        if(isset($json["name"]))
        {
            $wateringSystem = new $json["name"];
            $wateringSystem->values = $json["values"];
        }
        else
        {
            $wateringSystem = new \App\WateringSystems\NoWatering;
        }

        return $wateringSystem;
    }
}
