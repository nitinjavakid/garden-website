<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::register('garden', function ($breadcrumbs, $garden) {
    $breadcrumbs->parent('home');
    if($garden->id != null)
        $breadcrumbs->push($garden->name, route('garden.show', $garden));
});

Breadcrumbs::register('device', function ($breadcrumbs, $device) {
    $breadcrumbs->parent('garden', $device->garden);
    if($device->id != null)
        $breadcrumbs->push($device->name, route('device.show', $device));
});

Breadcrumbs::register('plant', function ($breadcrumbs, $plant) {
    $breadcrumbs->parent('device', $plant->device);
    if($plant->id != null)
        $breadcrumbs->push($plant->name, route('plant.show', $plant));
});

Breadcrumbs::register('task', function ($breadcrumbs, $task) {
    $breadcrumbs->parent('plant', $task->plant);
    if($task->id != null)
        $breadcrumbs->push($task->name, route('task.show', $task));
});
