<?php

namespace ComInterfaces\Devices\CashCode;

use ComInterfaces\ComInterfaces;
use ComInterfaces\Devices\CashCode\Commands\DeviceInfo;
use ComInterfaces\Devices\CashCode\Commands\Identification;

class CashCode extends ComInterfaces {
  const
    COMMAND_IDENTIFICATION = 1;

  private static $_instance   = null;
  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new CashCode();
    }
    return self::$_instance;
  }


  protected function setInterface() {
    $command = new Identification();
    //echo $command->getReceivedHexData();
    return $command->execute([
      'port' => "/dev/ttyUSB0"
    ]);
  }


  public function getDeviceInfo() {
    $command = new DeviceInfo($this->getInterface());
    $command->execute();
    return $command->getReceivedData();
  }

}