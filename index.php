<?php
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrapping here
use Basic\Bootstrap\BootstrapApp;

$app = new BootstrapApp();
$app->run();
