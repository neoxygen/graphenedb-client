<?php

namespace Neoxygen\GrapheneDBClient\Tests;

use Neoxygen\GrapheneDBClient\GrapheneDBClient;
use Symfony\Component\Yaml\Yaml;

class GrapheneDBClientTest extends \PHPUnit_Framework_TestCase
{
    private $createdDBName = 'helllllllll666';

    public function testGetVersions()
    {
        $client = $this->buildClient();
        $v = $client->getVersions();
        $this->assertArrayHasKey('default', $v);
        $this->assertArrayHasKey('versions', $v);
        $this->assertNotEmpty($v['versions']);
    }

    public function testCreateDatabase()
    {
        $client = $this->buildClient();
        $dbName = $this->createdDBName;
        $db = $client->createDatabase($dbName);
        $this->assertEquals($dbName, $db->getName());
    }

    public function testGetDatabase()
    {
        $client = $this->buildClient();
        $dbs = $client->getDatabases();
        $this->assertTrue(count($dbs) >= 1);

        $db = $client->getDatabase($this->createdDBName);
        $this->assertEquals($this->createdDBName, $db->getName());
    }

    public function testDeleteDatabase()
    {
        $client = $this->buildClient();
        $db = $client->getDatabase($this->createdDBName);
        $client->deleteDatabase($db->getId());
        $dbs = $client->getDatabases();
        $this->assertFalse(array_key_exists($this->createdDBName, $dbs));
    }

    private function buildClient()
    {
        print_r(get_defined_vars());
        if (getenv('GRAPHENEDB_USER') == null){
            $file = getcwd().'/graphenedb_info.yml';
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