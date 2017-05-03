<?php
namespace Taakin\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Taakin\Models\Customer;

/**
 *
 */
class CustomerController {

  public static function index( Request $request, Application $app ) {
    // show all

    $customers = Customer::where( 'user_id', $request->attributes->get('userid') )->get();

    return $app->json( $customers, 200 );
  }

  public static function show( Request $request, Application $app, $id ) {
    // show the customer #id
    $payload = [];
    $customer = Customer::where( 'id', $id )->get();

    if ( ! $customer->isEmpty() )
      $payload = $customer->first();

    return $app->json( $payload, 200 );
  }

  public static function store( Request $request, Application $app ) {
    // create a new customer, using POST method
    $code     = 400;
    $payload  = [];
    $customer = new Customer();

    $customer->user_id = $request->attributes->get('userid');

    foreach ($request->request as $key => $value)
      $customer->{$key} = $value;

    if ( $customer->save() ) {
      $payload = ['customer_id' => $customer->id, 'customer_uri' => '/customers/' . $customer->id];
      $code = 201;
    }

    return $app->json( $payload, $code );
  }

  public static function update( Request $request, Application $app, $id ) {
    // update the customer #id, using PUT method
    $code     = 400;
    $payload  = [];
    $customer = Customer::find( $id );

    if ( empty( $customer ) )
      return $app->json( $payload, $code );

    foreach ($request->request as $key => $value)
      $customer->{$key} = $value;

    if ( $customer->save() ) {
      $payload = ['customer_id' => $customer->id, 'customer_uri' => '/customers/' . $customer->id];
      $code = 201;
    }

    return $app->json( $payload, $code );
  }

  public static function destroy( $id ) {
    // delete the customer #id, using DELETE method
    $customer = Customer::find( $id );
    $customer->delete();

    if ( $customer->exists )
      return new Response( '', 400 );
    else
      return new Response( '', 204 );
  }
}

?>
