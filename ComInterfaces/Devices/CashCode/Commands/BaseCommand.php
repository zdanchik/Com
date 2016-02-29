<?php

namespace ComInterfaces\Devices\CashCode\Commands;

abstract class BaseCommand {

  abstract public function execute($data = []);

  private $receivedData = null;
  protected function setReceivedData($data) {
    $this->receivedData = $data;
  }


  public function getReceivedData($hex = false) {
    $sync = self::hex($this->receivedData[0]);
    $adr  = self::hex($this->receivedData[1]);
    $lng  = dechex(ord($this->receivedData[2]));

    $str = '';
    for ($i = 3; $i < $lng; $i++){
      $str .=  $hex ? self::hex($this->receivedData[$i]) : $this->receivedData[$i];
    }
    return $str;
  }


/*
  public static function strToHex($string){
    $str = '';
    foreach($string as $elm) {
      $str .= self::hex($elm);
    }
    return strToUpper($str);
  }
*/
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