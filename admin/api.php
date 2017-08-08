<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/aliases.php';

$project = new \Admin\EntryPoint\Api();
$project->init();
