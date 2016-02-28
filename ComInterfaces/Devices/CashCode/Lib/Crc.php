<?php
namespace ComInterfaces\Devices\CashCode\Lib;

class Crc {

  public static function crc16Kermit($string) {
    $crc = 0;
    for ( $x=0; $x<strlen( $string ); $x++ ) {
      $crc = $crc ^ ord( $string[$x] );
      for ($y = 0; $y < 8; $y++) {
        if ( ($crc & 0x0001) == 0x0001 ) $crc = ( ($crc >> 1 ) ^ 0x8408 );
        else                             $crc =    $crc >> 1;
      }
    }

    $lb  = ($crc & 0xff00) >> 8;
    $hb  = ($crc & 0x00ff) << 8;
    $crc = $hb | $lb;
    return $crc;
  }

}
