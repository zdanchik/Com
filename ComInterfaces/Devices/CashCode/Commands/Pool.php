<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class Pool extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_POOL));
  }
}