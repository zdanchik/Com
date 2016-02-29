<?php

namespace ComInterfaces\Devices\CashCode\Commands;

use ComInterfaces\Interfaces\Com\Serial;

abstract class SerialCommand extends BaseCommand {
  abstract protected function process();

  private $serial = null;
  public function __construct(Serial $serial) {
    $this->serial = $serial;
  }

  protected function getSerial() {
    return $this->serial;
  }

  public function execute() {
    $this->getSerial()->deviceOpen();
    $this->process();
    $this->setReceivedData($this->getSerial()->readPort());
  }
}