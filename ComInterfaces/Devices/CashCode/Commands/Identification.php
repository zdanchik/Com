<?php

namespace ComInterfaces\Devices\CashCode\Commands;

use ComInterfaces\Devices\CashCode\Lib\Crc;
use ComInterfaces\Interfaces\Com\Serial;

class Identification extends BaseCommand {

  public function execute($data) {
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

    // To write into
    $bytes = "";
    $bytes .= chr(0x02);
    $bytes .= chr(0x03);
    $bytes .= chr(0x06);
    $bytes .= chr(0x30);

    $bytes .= $this->crcToStr(Crc::crc16Kermit($bytes));    //CALC CRC16

    $serial->sendMessage($bytes);
    $read = $serial->readPort();
    return "SND: {$this->strToHex($bytes)} \tRCV: {$this->strToHex($read)} \n";
  }
}