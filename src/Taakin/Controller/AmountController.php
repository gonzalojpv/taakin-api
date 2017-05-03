<?php
namespace Taakin\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Taakin\Models\Amount;

/**
 *
 */
class AmountController {

  public static function index( Request $request, Application $app, $customer_id = NULL ) {

    $payload = [];

    if ( empty( $customer_id ) )
      return $app->json( [], 200);

    $results = Amount::where( 'customer_id', $customer_id )->get();

    return $app->json( $results, 200 );
  }

  public static function show( Request $request, Application $app, $id ) {
    // show the amount #id
    $payload = [];
    $amount = Amount::where( 'id', $id )->get();

    if ( ! $amount->isEmpty() )
      $payload = $amount->first();

    return $app->json( $payload, 200 );
  }

  public static function store( Request $request, Application $app ) {
    // create a new amount, using POST method
    $code = 400;
    $payload = [];
    $amount = new Amount();
    $amount->amount = $request->get('amount');
    $amount->customer_id = $request->get('customer_id');

    if ( $amount->save() ) {
      $payload = ['amount_id' => $amount->id, 'amount_uri' => '/amounts/' . $amount->id];
      $code = 201;
    }

    return $app->json( $payload, $code );

  }

  public static function update( Request $request, Application $app, $id ) {
    //Update the amount #id using PUT method
    $code    = 400;
    $payload = [];
    $amount  = Amount::find( $id );

    if ( empty( $amount ) )
      return $app->json( $payload, $code );

    $amount->amount = $request->get('amount');

    if ( ! empty( $request->get('deteled_at') ) )
      $amount->deteled_at = $request->get('deteled_at');

    if ( $amount->save() ) {
      $payload = ['amount_id' => $amount->id, 'amount_uri' => '/amounts/' . $amount->id];
      $code = 201;
    }

    return $app->json( $payload, $code );
  }

  public static function destroy( $id = NULL ) {
    // delete the amount #id, using DELETE method
    $amount = Amount::find( $id );
    $amount->delete();

    if ( $amount->exists )
      return new Response( '', 400 );
    else
      return new Response( '', 204 );
  }
}

?>
