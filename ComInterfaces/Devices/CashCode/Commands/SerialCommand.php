<?php

namespace ComInterfaces\Devices\CashCode\Commands;

use ComInterfaces\Interfaces\Com\Serial;

abstract class SerialCommand extends BaseCommand {

  private $serial = null;
  public function __construct(Serial $serial) {
    $this->serial = $serial;
  }

  protected function getSerial() {
    return $this->serial;
  }
}