<?php

namespace ComInterfaces;

use ComInterfaces\Interfaces\Com\Serial;

abstract class ComInterfaces {

  /**
   * @var $interface Serial
   */
  private $interface  = null;
  abstract protected function setInterface();
  abstract protected function closeInterface();

  /**
   * @return Serial
   */
  protected function getInterface() {
    return $this->interface;
  }

  protected function __construct() {
    $this->interface = $this->setInterface();
  }

  public function __destruct() {
    $this->closeInterface();
  }
}

