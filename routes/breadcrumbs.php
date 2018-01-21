<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

Breadcrumbs::register('garden', function ($breadcrumbs, $garden) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($garden->name, route('garden.show', $garden));
});

Breadcrumbs::register('device', function ($breadcrumbs, $device) {
    $breadcrumbs->parent('garden', $device->garden);
    $breadcrumbs->push($device->name, route('device.show', $device));
});

Breadcrumbs::register('plant', function ($breadcrumbs, $plant) {
    $breadcrumbs->parent('device', $plant->device);
    $breadcrumbs->push($plant->name, route('plant.show', $plant));
});

Breadcrumbs::register('task', function ($breadcrumbs, $task) {
    $breadcrumbs->parent('plant', $task->plant);
    $breadcrumbs->push($task->name, route('task.show', $task));
});
