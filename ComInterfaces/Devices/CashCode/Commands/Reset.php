<?php

namespace ComInterfaces\Devices\CashCode\Commands;

use ComInterfaces\Devices\CashCode\Lib\Crc;
use ComInterfaces\Interfaces\Com\Serial;

class Reset extends BaseCommand {

  public function execute($data = []) {
    $port = isset($data['port']) ? $data['port'] : null;
    if (!$port)
      throw new \Exception('You must change device port!');
    $serial = new Serial();
    if (!$serial->deviceSet($port)) {
      throw new \Exception("COM NOT OPENED");
    }
    $serial->SaveParams();
    $serial->confStopBits(1);
    $serial->confFlowControl("none");
    $serial->confCharacterLength(8);
    $serial->confParity("none");
    // We can change the baud rate
    $serial->confBaudRate(9600);
    // Then we need to open it
    $serial->ValidatorSetOptions();
    $serial->deviceOpen();

    $serial->sendMessage($this->prepareCommand(self::COMMAND_RESET));
    $this->setReceivedData($serial->readPort());
    return $serial;
  }

}