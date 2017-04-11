<?php
namespace Todos\Provider;

use Silex\Application;
use Todos\Controller\Task;
use Silex\Api\ControllerProviderInterface;
/**
 *
 */
class TaskProvider implements ControllerProviderInterface {

  public function connect( Application $app ) {

    $task = $app["controllers_factory"];
    $self = new Task();

    $task->get("/", array( $self, "index" ) );

    $task->post("/", array( $self, "store" ) );

    $task->get("/{id}", array( $self, "show" ) );

    $task->put("/{id}", array( $self, "update" ) );

    $task->delete("/{id}", array( $self, "destroy" ) );

    return $task;

  }
}

?>
