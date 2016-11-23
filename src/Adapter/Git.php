<?php

namespace Westwing\Filesystem\Adapter;

use GitRestApi\Client as GitClient;
use shadiakiki1986\Flysystem\Git as GitAdapter;
use Westwing\Filesystem\Config\Adapter\Git as Config;

class Git extends AbstractAdapter
{
    private function getEndpoint($config) {
        if(!empty($config[Config::INDEX_ENDPOINT])) {
          return $config[Config::INDEX_ENDPOINT];
        }

        $endpoint = getenv('GITRESTAPI_ENDPOINT');
        if(!!$endpoint) {
          return $endpoint;
        }

        throw new \Exception('git-rest-api endpoint not defined in config.yml and not in env var GITRESTAPI_ENDPOINT. Aborting');
    }


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
        $endpoint = $this->getEndpoint($config);

        $client = new GitClient($endpoint);
        $repo = $client->cloneRemote($config[Config::INDEX_REMOTE],1);

        if(!empty($config[Config::INDEX_USERNAME])) {
            $repo->putConfig('user.name',$config[Config::INDEX_USERNAME]);
        }
        if(!empty($config[Config::INDEX_USEREMAIL])) {
            $repo->putConfig('user.email',$config[Config::INDEX_USEREMAIL]);
        }

        // initialize filesystem for further usage
        $push = !empty($config[Config::INDEX_PUSH])?$config[Config::INDEX_PUSH]:false;
        $pull = !empty($config[Config::INDEX_PULL])?$config[Config::INDEX_PULL]:false;

        $adapter = new GitAdapter($repo,$push,$pull);

        return $adapter;
    }
}
