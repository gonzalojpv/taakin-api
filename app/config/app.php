<?php
$app = new Silex\Application();

require __DIR__.'/../providers.php';
require __DIR__.'/../routes.php';

return $app;
?>
