<?php
namespace Todos\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Todos\Models\Task as TaskModel;
/**
 *
 */
class Task {

  public static function index( Request $request, Application $app ) {
    $task = TaskModel::where('user_id', $request->attributes->get('userid'))->get();
    $payload = [];

    foreach ($task as $msg){

      $payload[] =
        [
          'id' => $msg->id,
          'title' => $msg->title,
          'user_id' => $msg->user_id,
          'complete' => $msg->complete
        ];
    }

    return $app->json($payload, 200);
  }

  public static function show( Request $request, Application $app, $id ){
    // show the task #id
    $task = TaskModel::where( 'id', $id )->get();

    foreach ($task as $msg){
      $payload[] =
        [
          'id' => $msg->id,
          'title' => $msg->title,
          'user_id' => $msg->user_id,
          'created_at' => $msg->created_at
        ];
    }

    return $app->json($payload, 200);
  }

  public static function store( Request $request, Application $app ){
    // create a new task, using POST method
    $code = 400;
    $_task = $request->get('title');
    $_complete = 0;

    if ( ! empty( $request->get('complete') )  && 'true' == $request->get('complete') )
      $_complete = 1;

    $task  = new TaskModel();
    $task->title    = $_task;
    $task->complete    = $_complete;
    $task->user_id = $request->attributes->get('userid');

    if ( $task->save() ) {
      $payload = ['task_id' => $task->id, 'task_uri' => '/tasks/' . $task->id];
      $code = 201;
    }
    else
      $payload = [];

    return $app->json($payload, $code);

  }

  public static function update( Request $request, Application $app, $id ){
    // update the task #id, using PUT method
    $code = 400;
    $_task = $request->get('title');
    $_complete = 0;

    if ( 'true' == $request->get('complete') )
      $_complete = 1;

    $task = TaskModel::find( $id );
    $task->title = $_task;
    $task->complete = $_complete;

    $task->save();

    if ( $task->id ) {
      $payload = ['task_id' => $task->id, 'task_uri' => '/tasks/' . $task->id];
      $code = 201;
    }
    else
      $payload = [];

    return $app->json( $payload, $code );
  }

  public static function destroy( $id ){
    // delete the task #id, using DELETE method
    $task = TaskModel::find( $id );
    $task->delete();

    if ( $task->exists )
      return new Response( '', 400 );
    else
      return new Response( '', 204 );
  }
}

?>
