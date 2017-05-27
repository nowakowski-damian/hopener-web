<?php
$path = $_SERVER['DOCUMENT_ROOT'].'/hopener/';
require_once($path.'db/DeviceModel.php');
require_once($path.'utils/Config.php');
require_once($path.'api/RestHelper.php');



class DatabaseManager {

    private $dbConnection;
    private $restHelper;

    public function __construct()
    {   $this->restHelper = new RestHelper();
        $this->dbConnection = @new mysqli(Config::HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
        if ( $this->dbConnection->connect_errno!=0 ) {
            $this->restHelper->setHttpCode(500);
            $this->restHelper->echoJson("Database error: ".$this->dbConnection->connect_errno);
            exit();
        }
    }

    public function closeConnetion() {
        $this->dbConnection->close();
    }

    private function sanitize($userInput) {
        return mysqli_real_escape_string($this->dbConnection, htmlentities($userInput, ENT_QUOTES, "UTF-8") );
    }

    private function query($queryString) {
        return @$this->dbConnection->query($queryString);
    }

    public function isUserCorrect($userName) {

        $sql = sprintf("SELECT * FROM user WHERE login='%s'",$this->sanitize($userName) );
        if( $result = $this->query($sql) ) {
            return $result->num_rows > 0;
        }
        return false;
    }

    public function isPasswordCorrect($userName, $password) {
        $sql = sprintf("SELECT * FROM user WHERE login='%s'",$this->sanitize($userName));
        if( ($result = $this->query($sql)) && $result->num_rows>0 ) {
            $dbRow =  $result->fetch_assoc();
            $result->free();
            if ( password_verify($password,$dbRow["password"]) ) {
                return true;
            }
        }
        return false;
    }

    public function getDevices() {
        $sql = "SELECT * FROM device";
        if( $result = $this->query($sql) ) {
            $devices = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $devicesList = [];
            foreach( $devices as $deviceRow ) {
                $devicesList[] = new DeviceModel($deviceRow);
            }
            return $devicesList;
        }
        return null;
    }

    public function addDevice($uuid,$name,$garage,$fence) {
        $sql = sprintf("INSERT INTO device (uuid,name,garage,fence) VALUES('%s','%s','%d','%d')"
            ,$uuid,$name, $garage, $fence );
        return $this->query($sql);
    }

    public function removeDevice($deviceId) {
        $sql = sprintf("DELETE FROM device WHERE id='%d'",$deviceId);
        return $this->query($sql);
    }

    public function getDevice($uuid) {
        $sql = "SELECT * FROM device";
        if( $result = $this->query($sql) ) {
            $devices = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            foreach( $devices as $deviceRow ) {
                if( password_verify($uuid,$deviceRow["uuid"]) ) {
                    return new DeviceModel($deviceRow);
                }
            }
        }
        return null;
    }

    public function incrementRequestCounter($deviceModel){
        $sql = sprintf("UPDATE device SET request_num=request_num+1 WHERE device.id=%d",$deviceModel->getId() );
        return $this->query($sql);
    }

}