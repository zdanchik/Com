<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class GetStatus extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_GET_STATUS));
  }
}