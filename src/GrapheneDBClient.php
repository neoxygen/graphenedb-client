<?php

namespace Neoxygen\GrapheneDBClient;

use Neoxygen\GrapheneDBClient\HttpClient\GuzzleHttpClient,
    Neoxygen\GrapheneDBClient\Database,
    Neoxygen\GrapheneDBClient\Exception\GrapheneDBClientException;

class GrapheneDBClient
{
    /**
     * @var
     */
    private $email;

    /**
     * @var
     */
    private $password;

    /**
     * @var GuzzleHttpClient
     */
    private $httpClient;

    /**
     * @var
     */
    private $userId;

    /**
     * @var
     */
    private $userRole;

    /**
     * @var array
     */
    private $databases = [];

    /**
     * @var array
     */
    private $dbMap = [];

    /**
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->httpClient = new GuzzleHttpClient();
    }

    /**
     * @return mixed
     * @throws GrapheneDBClientException
     */
    public function getVersions()
    {
        $this->checkToken();
        $endpoint = 'https://app.graphenedb.com/databases/versions';
        $versions = json_decode($this->httpClient->send($endpoint, 'GET'), true);

        return $versions;
    }

    /**
     * @param $name
     * @param string $version
     * @return Database
     * @throws GrapheneDBClientException
     */
    public function createDatabase($name, $version = 'v215')
    {
        $this->checkToken();
        if (empty($this->databases)){
            $this->getDatabases();
        }
        if (array_key_exists($name, $this->databases)){
            throw new GrapheneDBClientException(sprintf('The database name "%s" is already in use.', $name));
        }
        $body = [
            'version' => $version,
            'name' => $name
        ];
        $endpoint = 'https://app.graphenedb.com/databases';
        $result = json_decode($this->httpClient->send($endpoint, 'POST', $body), true);
        $db = new Database($result);
        $this->insertDbInMap($db);

        return $db;
    }

    /**
     * @return array
     * @throws GrapheneDBClientException
     */
    public function getDatabases()
    {
        $this->checkToken();
        $endpoint = 'https://app.graphenedb.com/databases';
        $response = json_decode($this->httpClient->send($endpoint, 'GET'), true);

        foreach ($response as $key => $dbInfo){
            $db = new Database($dbInfo);
            $this->insertDbInMap($db);
        }

        return $this->databases;
    }

    /**
     * @param $name
     * @return mixed
     * @throws GrapheneDBClientException
     */
    public function getDatabase($name)
    {
        $this->checkToken();
        if (empty($this->databases)){
            $this->getDatabases();
        }
        if(!array_key_exists($name, $this->databases)){
            throw new GrapheneDBClientException(sprintf('There is no database named "%s"', $name));
        }

        return $this->databases[$name];
    }

    /**
     * @param $id
     * @return bool
     * @throws GrapheneDBClientException
     */
    public function deleteDatabase($id)
    {
        $endpoint = 'https://app.graphenedb.com/databases/' . $id;
        $response = json_decode($this->httpClient->send($endpoint, 'DELETE'), true);

        $this->removeDbFromMap($id);

        return true;
    }

    /**
     *
     */
    public function deleteAllDatabases()
    {
        $this->checkToken();
        $this->getDatabases();
        foreach ($this->databases as $db){
            $this->deleteDatabase($db->getId());
        }
    }

    private function checkToken()
    {
        if (null === $this->userId){
            $this->getToken();
        }
    }

    private function getToken()
    {
        $body = [
            'email' => $this->email,
            'password' => $this->password
        ];

        $endpoint = 'https://app.graphenedb.com/users/login';
        $response = $this->httpClient->send($endpoint, 'POST', $body);

        $userInfo = \GuzzleHttp\json_decode($response, true);
        $this->userId = $userInfo['id'];
        $this->userRole = $userInfo['role'];
    }

    private function insertDbInMap(Database $database)
    {
        $id = $database->getId();
        $name = $database->getName();
        $this->databases[$name] = $database;
        $this->dbMap[$id] = $name;
    }

    private function removeDbFromMap($id)
    {
        $name = $this->dbMap[$id];
        unset($this->databases[$name]);
        unset($this->dbMap[$id]);
    }
}