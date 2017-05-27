<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 30/04/2017
 * Time: 4:00 PM
 */
class Request
{

//       -- Request model --
//
//    {
//        "uuid" : "*",
//        "device" : "garage/fence",
//        "activity" : "open/close/stop"
//    }
//

    private $uuid;
    private $device;
    private $activity;

    /**
     * Request constructor.
     * @param $uuid
     * @param $device
     * @param $activity
     */
    public function __construct($jsonString)
    {
        $json = json_decode($jsonString,true);
        if( $json!=null ) {
            $this->uuid = @$json["uuid"];
            $this->device = @$json["device"];
            $this->activity = @$json["activity"];
        }

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
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param mixed $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    public function isDataCorrect() {
        return $this->uuid!=null && $this->device!=null && $this->activity!=null;
    }

}