<?php

namespace ComInterfaces\Devices\CashCode;

use ComInterfaces\ComInterfaces;
use ComInterfaces\Devices\CashCode\Commands\Identification;

class CashCode extends ComInterfaces {
  const
    COMMAND_IDENTIFICATION = 1;


  public function execute($c, $data = []) {
    switch ($c) {
      case self::COMMAND_IDENTIFICATION:
         $command = new Identification();
        break;
      default:
        throw new \Exception("Undefined command");
    }
    return $command->execute($data);
  }

}