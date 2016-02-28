<?php

namespace ComInterfaces\Devices\CashCode\Commands;

abstract class BaseCommand {
  abstract public function execute($data);

  public static function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
      $ord = ord($string[$i]);
      $hexCode = dechex($ord);
      $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
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