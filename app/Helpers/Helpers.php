<?php

namespace App\Helpers;
use App\Helpers\getHomeDir;

class Helpers{

  public static function getHomeDir() {
    return getHomeDir::getHomeDir();
  }

}