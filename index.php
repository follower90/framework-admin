<?php

require_once('vendor/autoload.php');
require_once('config.php');
require_once('aliases.php');

$project = new \App\EntryPoint\Site();
$project->init();
