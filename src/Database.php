<?php

namespace Neoxygen\GrapheneDBClient;

class Database
{

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $webAdminUrl;

    /**
     * @var
     */
    private $authToken;

    /**
     * @var
     */
    private $status;

    /**
     * @var
     */
    private $nodesCount;

    /**
     * @var
     */
    private $relationshipsCount;

    /**
     * @var string
     */
    private $dbLocation;

    /**
     * @var
     */
    private $planName;

    /**
     * @var
     */
    private $memory;

    /**
     * @var
     */
    private $nodesLimit;

    /**
     * @var
     */
    private $relationshipsLimit;

    /**
     * @var
     */
    private $currentSize;

    /**
     * @var
     */
    private $maxSize;


    /**
     * @param array $databaseInfo
     */
    public function __construct(array $databaseInfo)
    {
        $this->id = $databaseInfo['id'];
        $this->name = $databaseInfo['name'];
        $this->url = $databaseInfo['url'];
        $this->webAdminUrl = $databaseInfo['webAdminURL'];
        $this->authToken = $databaseInfo['authToken'];
        $this->status = $databaseInfo['status'];
        $this->nodesCount = isset($databaseInfo['counters']['nodes']) ?: null;
        $this->relationshipsCount = isset($databaseInfo['counters']['relationships']) ?: null;
        $this->dbLocation = $databaseInfo['placement']['key'] . ' - ' .$databaseInfo['placement']['label'];
        $this->planName = $databaseInfo['plan']['name'];
        $this->memory = $databaseInfo['plan']['memory'];
        $this->nodesLimit = $databaseInfo['plan']['limits']['nodes'];
        $this->relationshipsLimit = $databaseInfo['plan']['limits']['relationships'];
        $this->currentSize = isset($databaseInfo['currentSize']) ?: null;
        $this->maxSize = $databaseInfo['maxSize'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getWebAdminUrl()
    {
        return $this->webAdminUrl;
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getNodesCount()
    {
        return $this->nodesCount;
    }

    /**
     * @return mixed
     */
    public function getRelationshipsCount()
    {
        return $this->relationshipsCount;
    }

    /**
     * @return string
     */
    public function getDbLocation()
    {
        return $this->dbLocation;
    }

    /**
     * @return mixed
     */
    public function getPlanName()
    {
        return $this->planName;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @return mixed
     */
    public function getNodesLimit()
    {
        return $this->nodesLimit;
    }

    /**
     * @return mixed
     */
    public function getRelationshipsLimit()
    {
        return $this->relationshipsLimit;
    }

    /**
     * @return mixed
     */
    public function getCurrentSize()
    {
        return $this->currentSize;
    }

    /**
     * @return mixed
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }


}