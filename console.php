#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use OS\Code\Boggle\Console\BoggleCommand;

$app = new Application('OS Tumblr', 'v1.0.0');
$app->add(new BoggleCommand());
$app->run();
