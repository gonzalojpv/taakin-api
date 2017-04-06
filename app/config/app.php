<?php

require __DIR__.'/../providers.php';
require __DIR__.'/../routes.php';

// Setting Database connections


$capsule->addConnection([
  "driver"     => "mysql",
  "host"       => "localhost",
  "database"   => "apisilex",
  "username"   => "root",
  "password"   => "gjpv",
  "charset"    => "utf8",
  "collation"  => "utf8_general_ci"
]);

$capsule->bootEloquent();

return $app;
?>
