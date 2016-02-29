<?php

namespace ComInterfaces\Devices\CashCode;

use ComInterfaces\ComInterfaces;
use ComInterfaces\Devices\CashCode\Commands\Identification;
use ComInterfaces\Devices\CashCode\Commands\Pool;
use ComInterfaces\Devices\CashCode\Commands\Reset;
use ComInterfaces\Interfaces\Com\Serial;

class CashCode extends ComInterfaces {

  const
    DEVICE_PORT = "/dev/ttyUSB0";

  private static $_instance   = null;
  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new CashCode();
    }
    return self::$_instance;
  }


  protected function setInterface() {
    $interface = new Serial();
    if (!$interface->deviceSet(self::DEVICE_PORT)) {
      throw new \Exception("COM NOT OPENED");
    }
    return $interface;
  }

  public function reset() {
    $command = new Reset($this->getInterface());
    $command->execute();
  }


  public function getIdentification() {

    $command = new Reset($this->getInterface());
    $command->execute();

    $command = new Identification($this->getInterface());
    $command->execute();
    $str = '';
    $command->getReceivedData(function ($hex, $bin) use (&$str) {
      $str .= $bin;
    });
    return $str;
  }


  public function pool() {
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      echo base_convert($hex, 16, 2) . "\n";
    });
  }

}