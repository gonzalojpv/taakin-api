<?php
namespace Admin\Provider;

use Silex\Application;
use Admin\Controller\UserController;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class UserProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $user = $app["controllers_factory"];
    $self = new UserController();

    $user->get("/", array( $self, "index" ) )->bind( 'user-list' );

    $user->get("/create/", array( $self, "store" ) )->bind( 'new-user' );
    
    $user->post("/create/", array( $self, "store" ) )->bind( 'create-user' );

    return $user;

  }
}

?>
