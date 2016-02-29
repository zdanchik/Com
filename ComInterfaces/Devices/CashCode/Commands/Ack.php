<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class Ack extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_ACK));
  }
}