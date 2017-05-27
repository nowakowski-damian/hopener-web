<?php

class GpioControllerLED
{

    const FENCE_OPEN_PIN = "8";
    const FENCE_PAUSE_PIN = "9";
    const FENCE_CLOSE_PIN = "7";

    const GARAGE_OPEN_PIN = "15";
    const GARAGE_PAUSE_PIN = "16";
    const GARAGE_CLOSE_PIN = "1";

    private static $wasInitialized = false;


    public function __construct()
    {
        if( !GpioControllerLED::$wasInitialized ) {
            $this->setModeOut(GpioControllerLED::GARAGE_OPEN_PIN);
            $this->setModeOut(GpioControllerLED::GARAGE_PAUSE_PIN);
            $this->setModeOut(GpioControllerLED::GARAGE_CLOSE_PIN);

            $this->setModeOut(GpioControllerLED::FENCE_OPEN_PIN);
            $this->setModeOut(GpioControllerLED::FENCE_PAUSE_PIN);
            $this->setModeOut(GpioControllerLED::FENCE_CLOSE_PIN);

            GpioControllerLED::$wasInitialized = true;
        }
    }

    public function openGarage() {
        $this->setHigh(GpioControllerLED::GARAGE_OPEN_PIN);
        $this->setLow(GpioControllerLED::GARAGE_PAUSE_PIN);
        $this->setLow(GpioControllerLED::GARAGE_CLOSE_PIN);
    }

    public function closeGarage() {
        $this->setLow(GpioControllerLED::GARAGE_OPEN_PIN);
        $this->setLow(GpioControllerLED::GARAGE_PAUSE_PIN);
        $this->setHigh(GpioControllerLED::GARAGE_CLOSE_PIN);
    }

    public function pauseGarage() {
        $this->setLow(GpioControllerLED::GARAGE_OPEN_PIN);
        $this->setHigh(GpioControllerLED::GARAGE_PAUSE_PIN);
        $this->setLow(GpioControllerLED::GARAGE_CLOSE_PIN);
    }

    public function openFence() {
        $this->setHigh(GpioControllerLED::FENCE_OPEN_PIN);
        $this->setLow(GpioControllerLED::FENCE_PAUSE_PIN);
        $this->setLow(GpioControllerLED::FENCE_CLOSE_PIN);
    }

    public function closeFence() {
        $this->setLow(GpioControllerLED::FENCE_OPEN_PIN);
        $this->setLow(GpioControllerLED::FENCE_PAUSE_PIN);
        $this->setHigh(GpioControllerLED::FENCE_CLOSE_PIN);
    }

    public function pauseFence() {
        $this->setLow(GpioControllerLED::FENCE_OPEN_PIN);
        $this->setHigh(GpioControllerLED::FENCE_PAUSE_PIN);
        $this->setLow(GpioControllerLED::FENCE_CLOSE_PIN);
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