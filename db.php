<?php

  $mysqli = new mysqli("localhost","2442587","University2024?","db2442587");

  if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
?>
