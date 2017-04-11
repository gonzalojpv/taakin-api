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

  public static function index( Request $request ) {
    $task = TaskModel::where('user_id', $request->attributes->get('userid'))->get();
    $payload = [];

    foreach ($task as $msg){

      $payload[$msg->id] =
        [
          'title' => $msg->title,
          'user_id' => $msg->user_id,
          'created_at' => $msg->created_at
        ];
    }

    return json_encode($payload, JSON_UNESCAPED_SLASHES);
  }

  public static function show( Request $request, $id ){
    // show the task #id
    $task = TaskModel::where( 'id', $id )->get();

    foreach ($task as $msg){
      $payload[$msg->id] =
        [
          'title' => $msg->title,
          'user_id' => $msg->user_id,
          'created_at' => $msg->created_at
        ];
    }

    return json_encode($payload, JSON_UNESCAPED_SLASHES);
  }

  public static function store( Request $request, Application $app ){
    // create a new task, using POST method
    $code = 400;
    $_task = $request->get('task');
    $task  = new TaskModel();
    $task->title    = $_task;
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
    $_task = $request->get('task');
    $task = TaskModel::find( $id );
    $task->title = $_task;
    $task->save();

    if ( $task->id ) {
      $payload = ['task_id' => $task->id, 'task_uri' => '/tasks/' . $task->id];
      $code = 201;
    }
    else
      $payload = [];

    return $app->json( $payload, $code );
  }

  public static function destroy($id){
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
