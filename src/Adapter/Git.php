<?php

namespace Westwing\Filesystem\Adapter;

use GitRestApi\Client as GitClient;
use shadiakiki1986\Flysystem\Git as GitAdapter;
use Westwing\Filesystem\Config\Adapter\Git as Config;

class Git extends AbstractAdapter
{
    /**
     * Creates and return a new instance of the adapter.
     *
     * @author Shadi Akiki <shadiakiki1986@gmail.com>
     *
     * @param array $config The configuration array
     *
     * @return \shadiakiki1986\Flysystem\Git
     */
    public function make($config)
    {
        $client = new GitClient($config[Config::INDEX_ENDPOINT]);
        $repo = $client->cloneRemote($config[Config::INDEX_REMOTE],1);

        if(!empty($config[Config::INDEX_USERNAME])) {
            $repo->putConfig('user.name',$config[Config::INDEX_USERNAME]);
        }
        if(!empty($config[Config::INDEX_USEREMAIL])) {
            $repo->putConfig('user.email',$config[Config::INDEX_USEREMAIL]);
        }

        // initialize filesystem for further usage
        $push = !empty($config[Config::INDEX_PUSH])?strtolower($config[Config::INDEX_PUSH])=='true':false;
        $pull = !empty($config[Config::INDEX_PULL])?strtolower($config[Config::INDEX_PULL])=='true':false;

        $adapter = new GitAdapter($repo,$push,$pull);

        return $adapter;
    }
}
