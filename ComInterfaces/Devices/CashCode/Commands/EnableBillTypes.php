<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class EnableBillTypes extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_ENABLE_BILL_TYPES, [
      0x00, 0x00, 0xfc,
      0x00, 0x00, 0xfc
    ]));
  }
}