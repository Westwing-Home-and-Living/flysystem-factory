# Filesystem

[![Author](http://img.shields.io/badge/author-@titosemi-blue.svg?style=flat-square)](https://twitter.com/titosemi)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

# Description

Simple Factory for the [League\Flysystem](https://github.com/thephpleague/flysystem) filesystem abstraction library.

# Goals

* Provide a simpler way of creating the different adapters based on a configuration file.
* Add validations to the config file.
* Add Validation to the different adapters.
     
# Installation

Add the following lines to your composer.json:

```json
{
    "require": {
        "Westwing-Home-and-Living/flysystem-factory": "v0.2"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:Westwing-Home-and-Living/flysystem-factory.git"
        }
    ]
}
```

**Note: Modify the version accordingly**

## Integrations

Want to get started quickly? Check out the **Recipes** folder!

* Zend Framework 1

## Adapters

Adapters currently implemented:

* Local
* AwsS3

# Examples

## Providing the configuration to the Factory as an array
```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Westwing\Filesystem\Factory;
use Symfony\Component\Yaml\Yaml;

$config            = Yaml::parse(file_get_contents(__DIR__ . 'filesystem.yml'));
$fileSystemFactory = new Factory();

$fileSystemFactory->setConfig($config);

$fileSystem = $fileSystemFactory->get('localFS');

print_r($fileSystem->listContents());
```

## Providing a Yaml config file to the Factory
```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Westwing\Filesystem\Factory;

$fileSystemFactory = new Factory();
$fileSystemFactory->setConfigFile(__DIR__ . 'filesystem.yml');

$fileSystem = $fileSystemFactory->get('localFS');

print_r($fileSystem->listContents());
```

### For both examples, the Yaml config file used was:
```yaml
Filesystem:
  adapter:
    localFS:
      type: "Local"
      root: "."
    sharedFS:
      type: "AwsS3"
      key:
      secret:
      region:
      bucket:
      prefix:
      options:
        Body:
        ContentType:
        ContentLength:
```
