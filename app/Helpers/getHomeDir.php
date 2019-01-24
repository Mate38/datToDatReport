<?php

namespace App\Helpers;

class getHomeDir{

  public static function getHomeDir() {
    // getenv('HOME') isn't set on Windows and generates a Notice.
    $home = getenv('HOME');
    if (!empty($home)) {
      // home should never end with a trailing slash.
      $home = rtrim($home, '/');
    }
    elseif (!empty(getenv('HOMEDRIVE')) && !empty(getenv('HOMEPATH'))) {
      // home on windows
      $home = getenv('HOMEDRIVE').getenv('HOMEPATH');
      // If HOMEPATH is a root directory the path can end with a slash. Make sure
      // that doesn't happen.
      $home = rtrim($home, '\\/');
    }
    return empty($home) ? NULL : $home;
  }

}