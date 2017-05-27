<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 22/04/2017
 * Time: 5:57 PM
 */

class DeviceModel {

    private $id;
    private $uuid;
    private $name;
    private $garageAccess;
    private $fenceAccess;
    private $requestNum;
    private $timestamp;

    function __construct($deviceSqlResult)
    {
        $this->id = $deviceSqlResult["id"];
        $this->uuid = $deviceSqlResult["uuid"];
        $this->name = $deviceSqlResult["name"];
        $this->garageAccess = $deviceSqlResult["garage"];
        $this->fenceAccess = $deviceSqlResult["fence"];
        $this->requestNum = $deviceSqlResult["request_num"];
        $this->timestamp = $deviceSqlResult["update_time"];
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function hasGarageAccess()
    {
        return $this->garageAccess;
    }

    /**
     * @param mixed $garageAccess
     */
    public function setGarageAccess($garageAccess)
    {
        $this->garageAccess = $garageAccess;
    }

    /**
     * @return mixed
     */
    public function hasFenceAccess()
    {
        return $this->fenceAccess;
    }

    /**
     * @param mixed $fenceAccess
     */
    public function setFenceAccess($fenceAccess)
    {
        $this->fenceAccess = $fenceAccess;
    }

    /**
     * @return mixed
     */
    public function getRequestNum()
    {
        return $this->requestNum;
    }

    /**
     * @param mixed $requestNum
     */
    public function setRequestNum($requestNum)
    {
        $this->requestNum = $requestNum;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }




}