<?php
namespace Todos\Controller;
use Symfony\Component\HttpFoundation\Request;
use Todos\Models\Message as MessageModel;
/**
 *
 */
class Message {

  public static function edit($id){
    // show edit form
  }

  public static function show(Request $request, $id){
    // show the message #id
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

    return json_encode($payload, JSON_UNESCAPED_SLASHES);
  }

  public static function store(){
    // create a new message, using POST method
  }

  public static function update($id){
    // update the message #id, using PUT method
  }

  public static function destroy($id){
    // delete the message #id, using DELETE method
  }
}

?>
