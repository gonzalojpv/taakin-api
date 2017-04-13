<?php
namespace Todos\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Todos\Models\Message as MessageModel;
/**
 *
 */
class Message {

  public static function index( Request $request, Application $app ) {
    $message = MessageModel::where('user_id', $request->attributes->get('userid'))->get();
    $payload = [];

    foreach ($message as $msg){

      $payload[$msg->id] =
        [
          'body' => $msg->body,
          'user_id' => $msg->user_id,
          'created_at' => $msg->created_at
        ];
    }

    return $app->json($payload, 200);
  }

  public static function show( Request $request, Application $app, $id ){
    // show the message #id
    $message = MessageModel::where( 'id', $id )->get();

    foreach ($message as $msg){
      $payload[$msg->id] =
        [
          'body' => $msg->body,
          'user_id' => $msg->user_id,
          'created_at' => $msg->created_at
        ];
    }

    return $app->json($payload, 200);
  }

  public static function store( Request $request, Application $app ){
    // create a new message, using POST method
    $code = 400;
    $_message = $request->get('message');
    $message  = new MessageModel();
    $message->body    = $_message;
    $message->user_id = $request->attributes->get('userid');

    if ( $message->save() ) {
      $payload = ['message_id' => $message->id, 'message_uri' => '/messages/' . $message->id];
      $code = 201;
    }
    else
      $payload = [];

    return $app->json($payload, $code);

  }

  public static function update( Request $request, Application $app, $id ){
    // update the message #id, using PUT method
    $code = 400;
    $_message = $request->get('message');
    $message = MessageModel::find( $id );
    $message->body = $_message;
    $message->save();

    if ( $message->id ) {
      $payload = ['message_id' => $message->id, 'message_uri' => '/messages/' . $message->id];
      $code = 201;
    }
    else
      $payload = [];

    return $app->json( $payload, $code );
  }

  public static function destroy($id){
    // delete the message #id, using DELETE method
    $message = MessageModel::find( $id );
    $message->delete();

    if ( $message->exists )
      return new Response( '', 400 );
    else
      return new Response( '', 204 );
  }
}

?>
