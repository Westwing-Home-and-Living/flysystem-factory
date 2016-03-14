<?php

namespace Westwing\Filesystem\Adapter;

use League\Flysystem\Adapter\Ftp as FtpAdapter;

class Ftp extends AbstractAdapter
{
    public function make($config)
    {
        return new FtpAdapter($config);
    }
}

