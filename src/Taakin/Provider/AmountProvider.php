<?php
namespace Taakin\Provider;

use Silex\Application;
use Taakin\Controller\AmountController;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class AmountProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $payment = $app["controllers_factory"];
    $self = new AmountController();

    $payment->get("/{customer_id}/customer/", array( $self, "index" ) );

    $payment->post("/", array( $self, "store" ) );

    $payment->get("/{id}", array( $self, "show" ) );

    $payment->put("/{id}", array( $self, "update" ) );

    $payment->delete("/{id}", array( $self, "destroy" ) );

    return $payment;

  }
}

?>
