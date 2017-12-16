<?php

use Illuminate\Database\Seeder;

class TesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::firstOrCreate([
            "name" => "Nitin Anand",
            "email" => "gmail@an.andnit.in",
            "password" => bcrypt("test123")
        ]);

        $garden = App\Garden::firstOrCreate([
            "name" => "Home",
            "user_id" => $user->id
        ]);

        $device = App\Device::firstOrCreate([
            "name" => "Device 1",
            "garden_id" => $garden->id,
            "secret" => bcrypt("arsenal")
        ]);

        $plant = App\Plant::firstOrCreate([
            "name" => "Chilli",
            "device_id" => $device->id,
            "forward_pin" => "D6",
            "reverse_pin" => "D5",
            "adc_pin" => "C0"
        ]);

        $task = App\Task::firstOrCreate([
            "type" => "water",
            "time_interval" => 10,
            "plant_id" => $plant->id
        ]);
    }
}
