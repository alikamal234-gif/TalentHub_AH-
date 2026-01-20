<?php

$projectRoot = dirname(__DIR__);

require_once $projectRoot . '/vendor/autoload.php';

use App\Kernal;

new Kernal($projectRoot)->run();
