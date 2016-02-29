<?php

namespace ComInterfaces\Devices\CashCode\Commands;


class Reset extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_RESET));
  }

}