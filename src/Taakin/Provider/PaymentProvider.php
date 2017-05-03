<?php
namespace Taakin\Provider;

use Silex\Application;
use Taakin\Controller\PaymentController;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class PaymentProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $payment = $app["controllers_factory"];
    $self = new PaymentController();

    $payment->get("/{customer_id}/customer/", array( $self, "index" ) );

    $payment->post("/", array( $self, "store" ) );

    $payment->get("/{id}", array( $self, "show" ) );

    $payment->put("/{id}", array( $self, "update" ) );

    $payment->delete("/{id}", array( $self, "destroy" ) );

    return $payment;

  }
}

?>
