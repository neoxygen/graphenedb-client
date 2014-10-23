<?php

namespace Neoxygen\GrapheneDBClient\Tests;

use Neoxygen\GrapheneDBClient\GrapheneDBClient;
use Symfony\Component\Yaml\Yaml;

class GrapheneDBClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConnection()
    {
        $client = $this->buildClient();

        print_r($client->getVersions());
    }

    private function buildClient()
    {
        if (!getenv('GRAPHENEDB_USER')){
            $file = getcwd().'/.graphenedb_info.yml';
            $info = Yaml::parse($file);
        } else {
            $info = [
                'email' => getenv('GRAPHENEDB_USER'),
                'password' => getenv('GRAPHENEDB_PASSWORD')
            ];
        }

        $client = new GrapheneDBClient($info['email'], $info['password']);

        return $client;
    }
}