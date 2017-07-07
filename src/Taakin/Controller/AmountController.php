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
    $amount->start_date = $request->get('start_date');
    $amount->code = self::getToken(10);

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

  private static function crypto_rand_secure( $min, $max ) {
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
  }

  private static function getToken( $length ) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[self::crypto_rand_secure(0, $max-1)];
    }

    return $token;
  }
}

?>
