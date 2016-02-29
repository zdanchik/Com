<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class Identification extends SerialCommand {

  public function execute($data = []) {

    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_IDENTIFICATION));
    $this->setReceivedData($this->getSerial()->readPort());
  }
}