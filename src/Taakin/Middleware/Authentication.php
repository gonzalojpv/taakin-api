<?php
namespace Taakin\Middleware;
use Taakin\Models\User;
/**
 *
 */
class Authentication
{
  public static function authenticate( $request, $app ) {

    $auth = $request->headers->get("Auth");
    $apikey = substr($auth, strpos($auth, ' '));
    $apikey = trim($apikey);
    $user = new User();
    $check = $user->authenticate($apikey);

    if ( 0 === $check ) {
      $app->abort(401, 'You shall not pass');
    }
    else
      $request->attributes->set( 'userid', $check );
  }
}

?>
