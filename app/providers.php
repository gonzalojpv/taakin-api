<?php
use Silex\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Taakin\Middleware\Authentication as TodoAuth;

Request::enableHttpMethodParameterOverride();

$app     = new Application();
$capsule = new Capsule();


$app->before(function( $request, $app ) {

  $app['twig']->addGlobal('current_page_name', $request->getRequestUri());

  if ( '/' != $request->getRequestUri() )
    TodoAuth::authenticate($request, $app);
});

$app->register(new AssetServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), [
  "cors.allowOrigin" => "*",
]);
$app->register(new Silex\Provider\TwigServiceProvider(), [
  'twig.path' => __DIR__ . '/../src/Admin/Views'
]);
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));


$app->after(function (Request $request, Response $response) {
  $response->headers->set('Access-Control-Allow-Origin', '*');
  $response->headers->set('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version, Origin, auth');
  $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
});

?>
