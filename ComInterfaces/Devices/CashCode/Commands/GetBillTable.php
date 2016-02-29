<?php

namespace ComInterfaces\Devices\CashCode\Commands;

class GetBillTable extends SerialCommand {
  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_GET_BILL_TABLE));
  }
}