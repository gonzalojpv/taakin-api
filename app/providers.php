<?php
use Silex\Application;
use Illuminate\Database\Capsule\Manager as Capsule;


use Todos\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Todos\Middleware\Authentication as TodoAuth;

Request::enableHttpMethodParameterOverride();

$app     = new Application();
$capsule = new Capsule();


$app->before(function( $request, $app ) {
  TodoAuth::authenticate($request, $app);
});
?>
