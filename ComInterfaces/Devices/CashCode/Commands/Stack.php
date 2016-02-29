<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class Stack extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_STACK));
  }
}