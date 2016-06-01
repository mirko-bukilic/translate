#!/usr/bin/env php
<?php

chdir(realpath(dirname(__DIR__)."/../../../"));

require_once './vendor/autoload.php';

use G4\Translate\Json\TransJson;
use G4\Translate\Json\TransPath;
use G4\Translate\Json\TransName;
use G4\Commando\Cli;

$cli = new Cli();
$cli->version('x.x.x');
$cli->option()->short("p")
    ->long("name")
    ->desc('name');
$cli->option()->short("p")
    ->long("path")
    ->desc('locale path');

(new TransJson(
    new TransPath($cli->value('path'), new TransName($cli->value('name')))
))->execute();
