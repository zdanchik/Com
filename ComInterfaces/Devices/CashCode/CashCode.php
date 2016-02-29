<?php

namespace ComInterfaces\Devices\CashCode;

use ComInterfaces\ComInterfaces;
use ComInterfaces\Devices\CashCode\Commands\Ack;
use ComInterfaces\Devices\CashCode\Commands\EnableBillTypes;
use ComInterfaces\Devices\CashCode\Commands\GetBillTable;
use ComInterfaces\Devices\CashCode\Commands\GetStatus;
use ComInterfaces\Devices\CashCode\Commands\Identification;
use ComInterfaces\Devices\CashCode\Commands\Pool;
use ComInterfaces\Devices\CashCode\Commands\Reset;
use ComInterfaces\Devices\CashCode\Commands\Stack;
use ComInterfaces\Interfaces\Com\Serial;

class CashCode extends ComInterfaces {

  const
    DEVICE_PORT = "/dev/ttyUSB0";

  private static $_instance   = null;
  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new CashCode();
    }
    return self::$_instance;
  }


  protected function setInterface() {
    $interface = new Serial();
    if (!$interface->deviceSet(self::DEVICE_PORT)) {
      throw new \Exception("COM NOT OPENED");
    }
    $interface->confStopBits(1);
    $interface->confFlowControl("none");
    $interface->confCharacterLength(8);
    $interface->confParity("none");
    // We can change the baud rate
    $interface->confBaudRate(9600);
    // Then we need to open it
    $interface->ValidatorSetOptions();
    $interface->deviceOpen();
    return $interface;
  }

  protected function closeInterface() {
    echo "--CLOSED--!!!!";
    $this->getInterface()->deviceClose();
    $this->getInterface()->RestoreParams();
  }

  public function reset() {
    $command = new Reset($this->getInterface());
    $command->execute();
  }


  public function getIdentification() {

    $command = new Reset($this->getInterface());
    $command->execute();

    $command = new Identification($this->getInterface());
    $command->execute();
    $str = '';
    $command->getReceivedData(function ($hex, $bin) use (&$str) {
      $str .= $bin;
    });
    return $str;
  }


  public function pool() {
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . "\n";
    });
  }

  public function stack() {
    $command = new Stack($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . "\n";
    });
  }

  public function ack() {
    $command = new Ack($this->getInterface());
    $command->execute();
  }

  public function poolAck() {
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();


    $command = new Reset($this->getInterface());
    $command->execute();

    echo "-1\n";
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    echo "-2\n";

    $command = new GetStatus($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();

    echo "-3\n";
    $command = new GetBillTable($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex;
    });


    $command = new Ack($this->getInterface());
    $command->execute();

    echo "-4\n";

    $command = new Identification($this->getInterface());
    $command->execute();
    $str = '';
    $command->getReceivedData(function ($hex, $bin) use (&$str) {
      $str .= $bin;
    });

    $command = new Ack($this->getInterface());
    $command->execute();

    echo "$str----\n";

    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    echo "-5\n";

    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    echo "-6\n";

    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    echo "\n--------ENABLE SEQUENCE------\n";

    $command = new EnableBillTypes($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo "$hex ";
    });
    echo "-7\n";
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    echo "-8\n";
    $command = new Ack($this->getInterface());
    $command->execute();


    echo "\n--------Bill accepting sequence------\n";

    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    echo "-9\n";
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    sleep(5);
    echo "-10\n";
    $command = new Stack($this->getInterface());
    $command->execute();
    echo "-11\n";
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();
    echo "-12\n";
    sleep(2);

    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();

    echo "-13\n";

    sleep(5);
    echo "-10\n";
    $command = new Stack($this->getInterface());
    $command->execute();

    echo "-14\n";
    $command = new Pool($this->getInterface());
    $command->execute();
    $command->getReceivedData(function ($hex, $bin) {
      //echo base_convert($hex, 16, 2) . "\n";
      echo $hex . " ";
    });

    $command = new Ack($this->getInterface());
    $command->execute();

    echo "-FINISH\n";
  }

}