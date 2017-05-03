<?php
namespace Taakin\Provider;

use Silex\Application;
use Taakin\Controller\User;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class UserProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $user = $app["controllers_factory"];
    $self = new User();

    $user->post("/create", array( $self, "store" ) );

    $user->get("/{id}", array( $self, "show" ) );

    $user->get("/edit/{id}", array( $self, "edit" ) );

    $user->post("/{id}", array( $self, "update" ) );

    $user->post("/delete/{id}", array( $self, "destroy" ) );

    return $user;

  }
}

?>
