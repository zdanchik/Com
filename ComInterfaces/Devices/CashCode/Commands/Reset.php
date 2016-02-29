<?php

namespace ComInterfaces\Devices\CashCode\Commands;


class Reset extends SerialCommand {

  public function execute() {
    $this->getSerial()->confStopBits(1);
    $this->getSerial()->confFlowControl("none");
    $this->getSerial()->confCharacterLength(8);
    $this->getSerial()->confParity("none");
    // We can change the baud rate
    $this->getSerial()->confBaudRate(9600);
    // Then we need to open it
    $this->getSerial()->ValidatorSetOptions();
    parent::execute();
  }

  protected function process() {
    $this->getSerial()->sendMessage($this->prepareCommand(self::COMMAND_RESET));
    $this->setReceivedData($this->getSerial()->readPort());
  }

}