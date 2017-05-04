<?php
namespace Admin\Provider;

use Silex\Application;
use Admin\Controller\IndexController;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class IndexProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $admin = $app["controllers_factory"];
    $self = new IndexController();

    $admin->get("/", array( $self, "index" ) )->bind( 'home' );

    $admin->post("/", array( $self, "index" ) )->bind( 'login' );

    $admin->get("/logout/", array( $self, "logout" ) )->bind( 'logout' );

    $admin->get("/dashboard/", array( $self, "dashboard" ) )->bind( 'dashboard' );

    return $admin;

  }
}

?>
