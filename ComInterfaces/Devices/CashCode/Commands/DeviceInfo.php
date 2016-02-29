<?php

namespace ComInterfaces\Devices\CashCode\Commands;

use ComInterfaces\Devices\CashCode\Lib\Crc;

class DeviceInfo extends SerialCommand {

  public function execute($data = []) {

    // To write into
    $bytes = "";
    $bytes .= chr(0x02);
    $bytes .= chr(0x03);
    $bytes .= chr(0x06);
    $bytes .= chr(0x37);

    $bytes .= $this->crcToStr(Crc::crc16Kermit($bytes));    //CALC CRC16

    $this->getSerial()->sendMessage($bytes);
    $this->setReceivedData($this->getSerial()->readPort());
  }
}