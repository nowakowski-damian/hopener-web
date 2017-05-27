<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 30/04/2017
 * Time: 9:47 PM
 */
class RestHelper
{
    private $httpVersion = "HTTP/1.1";
    private $defaultContentType = "application/json";


    public function setHttpHeaders($contentType, $statusCode){
        $statusMessage = $this -> getHttpStatusMessage($statusCode);
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);
        header("Content-Type:". $contentType);
    }

    public function setHttpCode($statusCode){
        $this->setHttpHeaders($this->defaultContentType,$statusCode);
    }

    private function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            415 => 'Unsupported Media Type',
            500 => 'Internal Server Error',
        );
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

    public function echoJson($message) {
        echo json_encode( array('message' => $message) );
    }

}