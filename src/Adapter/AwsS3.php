<?php

namespace Westwing\Filesystem\Adapter;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Westwing\Filesystem\Config\Adapter\AwsS3 as Config;

class AwsS3 extends AbstractAdapter
{
    /**
     * Creates and return a new instance of the adapter.
     *
     * @author Damian Gręda <damian.greda@westwing.de>
     *
     * @param array $config The configuration array
     *
     * @return \League\Flysystem\AwsS3v3\AwsS3Adapter
     */
    public function make($config)
    {
        $prefix  = (!empty($config[Config::INDEX_PREFIX]) ? $config[Config::INDEX_PREFIX] : null);
        $options = (!empty($config[Config::INDEX_OPTIONS]) ? $config[Config::INDEX_OPTIONS] : array());

        $client = new S3Client(array(
            Config::INDEX_CREDENTIALS => array(
                Config::INDEX_KEY    => $config[Config::INDEX_KEY],
                Config::INDEX_SECRET => $config[Config::INDEX_SECRET],
            ),
            Config::INDEX_REGION      => $config[Config::INDEX_REGION],
            Config::INDEX_VERSION     => $config[Config::INDEX_VERSION],
        ));

        $adapter = new AwsS3Adapter($client, $config[Config::INDEX_BUCKET], $prefix, $options);

        return $adapter;
    }
}

