<?php

  include('Homepath.php');

  function getNumbersFromString($str) {
    return preg_replace("/[^0-9-.]/", "", $str);
  }