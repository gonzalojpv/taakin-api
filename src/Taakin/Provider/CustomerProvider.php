<?php
namespace Taakin\Provider;

use Silex\Application;
use Taakin\Controller\CustomerController;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class CustomerProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $customer = $app["controllers_factory"];
    $self = new CustomerController();

    $customer->get("/", array( $self, "index" ) );

    $customer->post("/", array( $self, "store" ) );

    $customer->get("/{id}", array( $self, "show" ) );

    $customer->put("/{id}", array( $self, "update" ) );

    $customer->delete("/{id}", array( $self, "destroy" ) );

    return $customer;

  }
}

?>
