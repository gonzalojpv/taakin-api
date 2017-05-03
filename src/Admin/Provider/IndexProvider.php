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

    $admin->get("/", array( $self, "index" ) );

    $admin->post("/create", array( $self, "store" ) );

    $admin->get("/{id}", array( $self, "show" ) );

    $admin->get("/edit/{id}", array( $self, "edit" ) );

    $admin->post("/{id}", array( $self, "update" ) );

    $admin->post("/delete/{id}", array( $self, "destroy" ) );

    return $admin;

  }
}

?>
