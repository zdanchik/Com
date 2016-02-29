<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class Identification extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_IDENTIFICATION));
  }
}