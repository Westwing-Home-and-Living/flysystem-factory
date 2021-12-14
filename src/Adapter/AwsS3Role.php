<?php

namespace Westwing\Filesystem\Adapter;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Westwing\Filesystem\Config\Adapter\AwsS3Role as Config;

class AwsS3Role extends AbstractAdapter
{
    /**
     * Creates and return a new instance of the adapter.
     *
     * @param array $config The configuration array
     *
     * @return \League\Flysystem\AwsS3v3\AwsS3Adapter
     * @author Faizan Khan <faizanahmed.khan@westwing.de>
     *
     */
    public function make($config)
    {
        $prefix  = (!empty($config[Config::INDEX_PREFIX]) ? $config[Config::INDEX_PREFIX] : null);
        $options = (!empty($config[Config::INDEX_OPTIONS]) ? $config[Config::INDEX_OPTIONS] : array());

        $client = new S3Client(array(
            Config::INDEX_REGION  => $config[Config::INDEX_REGION],
            Config::INDEX_VERSION => $config[Config::INDEX_VERSION],
        ));

        $adapter = new AwsS3Adapter($client, $config[Config::INDEX_BUCKET], $prefix, $options);

        return $adapter;
    }
}

