<?php

namespace ComInterfaces\Devices\CashCode;

use ComInterfaces\ComInterfaces;
use ComInterfaces\Devices\CashCode\Commands\Identification;
use ComInterfaces\Devices\CashCode\Commands\Reset;

class CashCode extends ComInterfaces {

  private static $_instance   = null;
  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new CashCode();
    }
    return self::$_instance;
  }


  protected function setInterface() {
    $command = new Reset();
    return $command->execute([
      'port' => "/dev/ttyUSB0"
    ]);
  }


  public function getIdentification() {
    $command = new Identification($this->getInterface());
    $command->execute();
    return $command->getReceivedData();
  }

}