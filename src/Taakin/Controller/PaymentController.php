<?php
namespace Taakin\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Taakin\Models\Payment;

/**
 *
 */
class PaymentController {

  public static function index( Request $request, Application $app, $customer_id ) {
    // get all payments of the customer
    $payments = Payment::where( 'customer_id', $customer_id )->get();

    return $app->json( $payments, 200 );
  }

  public static function show( Request $request, Application $app, $id ) {
    // show the payment #id
    $payload = [];
    $payment = Payment::where( 'id', $id )->get();

    if ( ! $payment->isEmpty() )
      $payload = $payment->first();

    return $app->json( $payload, 200 );
  }

  public static function store( Request $request, Application $app ) {
    // create a new payment, using POST method
    $code     = 400;
    $payload  = [];
    $payment = new Payment();

    foreach ($request->request as $key => $value)
      $payment->{$key} = $value;

    if ( $payment->save() ) {
      $payload = ['payment_id' => $payment->id, 'payment_uri' => '/payments/' . $payment->id];
      $code = 201;
    }

    return $app->json( $payload, $code );
  }

  public static function update( Request $request, Application $app, $id ) {
    // update the payment #id, using PUT method
    $code    = 400;
    $payload = [];
    $payment = Payment::find( $id );

    if ( empty( $payment ) )
      return $app->json( $payload, $code );

    foreach ($request->request as $key => $value)
      $payment->{$key} = $value;

    if ( $payment->save() ) {
      $payload = ['payment_id' => $payment->id, 'payment_uri' => '/payments/' . $payment->id];
      $code = 201;
    }

    return $app->json( $payload, $code );
  }

  public static function destroy( $id ) {
    // delete the payment #id, using DELETE method
    $payment = Payment::find( $id );
    $payment->delete();

    if ( $payment->exists )
      return new Response( '', 400 );
    else
      return new Response( '', 204 );
  }

}

?>
