<?php
namespace Todos\Provider;

use Silex\Application;
use Todos\Controller\Message;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class MessageProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $message = $app["controllers_factory"];
    $self = new Message();

    $message->get("/", array( $self, "index" ) );

    $message->post("/create", array( $self, "store" ) );

    $message->get("/{id}", array( $self, "show" ) );

    $message->get("/edit/{id}", array( $self, "edit" ) );

    $message->post("/{id}", array( $self, "update" ) );

    $message->post("/delete/{id}", array( $self, "destroy" ) );

    return $message;

  }
}

?>
