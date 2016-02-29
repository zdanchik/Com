<?php

namespace ComInterfaces\Devices\CashCode\Commands;

use ComInterfaces\Devices\CashCode\Lib\Crc;

abstract class BaseCommand {

  const
    COMMAND_IDENTIFICATION  = 0x37,
    COMMAND_RESET           = 0x30,
    COMMAND_POOL            = 0x33,
    COMMAND_STACK           = 0x35,
    COMMAND_GET_STATUS      = 0x31,
    COMMAND_GET_BILL_TABLE  = 0x41,
    COMMAND_ENABLE_BILL_TYPES = 0x34,

    COMMAND_ACK             = 0x00;

  const
    ERR_NOT_VALID_COMMAND   = "ff",
    ERR_ILLEGAL_COMMAND     = "30";

  abstract public function execute();

  private $receivedData = null;
  protected function setReceivedData($data) {
    $this->receivedData = $data;
  }


  protected function prepareCommand($command, $data = []) {
    $bytes  = "";
    $bytes .= chr(0x02);
    $bytes .= chr(0x03);
    $bytes .= chr((0x06 + count($data)) % 255);
    $bytes .= chr($command);
    if ($data) {
      foreach ($data as $byte) {
        $bytes .= chr($byte);
      }
    }
    $bytes .= $this->crcToStr(Crc::crc16Kermit($bytes));
    return $bytes;
  }


  public function getReceivedData(callable $callback) {
    //$sync = self::hex($this->receivedData[0]);
    //$adr  = self::hex($this->receivedData[1]);
    if (empty($this->receivedData))
      throw new \Exception("Empty data! Not correct initialization service!");

    $lng  = dechex(ord($this->receivedData[2]));
    $err  = dechex(ord($this->receivedData[3]));
    if (in_array($err,[ self::ERR_NOT_VALID_COMMAND, self::ERR_ILLEGAL_COMMAND]))
      throw new \Exception("Device return error state ($err) for " . get_called_class());

    //$str = '';
    for ($i = 3; $i < $lng; $i++){
      if ($callback != null) {
        $callback(self::hex($this->receivedData[$i]) , $this->receivedData[$i]);
      }
      //$str .=  $hex ? self::hex($this->receivedData[$i]) : $this->receivedData[$i];
    }
    //return $str;
  }

  private function hex($i) {
    return substr('0'.dechex(ord($i)), -2);
  }

  public static function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
      $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
  }

  public static function crcToStr($crc)
  {
    $lb  = ($crc & 0xff00)>> 8;
    $hb  = ($crc & 0x00ff);
    $str="";
    $str.=chr($lb);
    $str.=chr($hb);
    return $str;
  }

}