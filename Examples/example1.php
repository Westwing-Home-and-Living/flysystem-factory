<?php

// Providing the configuration to the Factory as an array

require_once __DIR__ . '/../vendor/autoload.php';

use Westwing\Filesystem\Factory;
use Symfony\Component\Yaml\Yaml;

$config            = Yaml::parse(file_get_contents(__DIR__ . 'filesystem.yml'));
$fileSystemFactory = new Factory();

$fileSystemFactory->setConfig($config);

$fileSystem = $fileSystemFactory->get('localFS');

print_r($fileSystem->listContents());
