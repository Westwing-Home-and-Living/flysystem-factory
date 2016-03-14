<?php

// Providing a Yaml config file to the Factory

require_once __DIR__ . '/../vendor/autoload.php';

use Westwing\Filesystem\Factory;

$fileSystemFactory = new Factory();
$fileSystemFactory->setConfigFile(__DIR__ . '/filesystem.yml');

$fileSystem = $fileSystemFactory->get('ftp');

print_r($fileSystem->listContents());
