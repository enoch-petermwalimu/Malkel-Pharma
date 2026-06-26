<?php

use App\Modules\Settings\Controllers\SettingsController;

// Settings routes
$settingsController = new SettingsController();

// Route: GET /settings
if ($_SERVER['REQUEST_URI'] === '/settings' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $settingsController->index();
    exit;
}

// Route: POST /settings/update
if ($_SERVER['REQUEST_URI'] === '/settings/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $settingsController->update();
    exit;
}
