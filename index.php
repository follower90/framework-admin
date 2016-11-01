<?php

require_once('vendor/autoload.php');
require_once('config.php');

$project = new \App\EntryPoint\Site();
$project->init();
