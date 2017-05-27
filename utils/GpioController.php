<?php

class GpioController
{

    const FENCE_RELAY_PIN = "8";
    const GARAGE_RELAY_PIN = "9";


    private static $wasInitialized = false;
    private $isSleeping = false;


    public function __construct()
    {
        if( !GpioController::$wasInitialized ) {
            $this->setModeOut(GpioController::FENCE_RELAY_PIN);
            $this->setModeOut(GpioController::GARAGE_RELAY_PIN);
            $this->setHigh(GpioController::FENCE_RELAY_PIN);
            $this->setHigh(GpioController::GARAGE_RELAY_PIN);
            GpioController::$wasInitialized = true;
        }
    }

    private function runRelay($pinNumber,$seconds) {
        if( !$this->isSleeping ) {
            $this->isSleeping = true;
            $this->setLow($pinNumber);
            sleep($seconds);
            $this->setHigh($pinNumber);
            $this->isSleeping = false;
        }
    }

    public function openGarage() {
        $this->runRelay(GpioController::GARAGE_RELAY_PIN,2);
    }

    public function closeGarage() {
        $this->runRelay(GpioController::GARAGE_RELAY_PIN,2);
    }

    public function pauseGarage() {
        $this->runRelay(GpioController::GARAGE_RELAY_PIN,2);
    }

    public function openFence() {
        $this->runRelay(GpioController::FENCE_RELAY_PIN,2);
    }

    public function closeFence() {
        $this->runRelay(GpioController::FENCE_RELAY_PIN,2);
    }

    public function pauseFence() {
        $this->runRelay(GpioController::FENCE_RELAY_PIN,2);
    }

    private function setModeOut($pinNumber) {
        shell_exec('/usr/local/bin/gpio mode '.$pinNumber.' out');
    }

    private function setHigh($pinNumber) {
        shell_exec('/usr/local/bin/gpio write '.$pinNumber.' 1');
    }

    private function setLow($pinNumber) {
        shell_exec('/usr/local/bin/gpio write '.$pinNumber.' 0');
    }

}