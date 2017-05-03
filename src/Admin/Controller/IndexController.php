<?php
namespace Admin\Controller;
use Silex\Application;

/**
 *
 */
class IndexController {

  public static function index( Application $app ) {

    return $app['twig']->render('admin/home.twig', ['name' => 'Fabien']);
  }

  public static function edit( $id ) {
    // show edit form
  }

  public static function show( $id ) {
    // show the user #id
  }

  public static function store() {
    // create a new user, using POST method
  }

  public static function update( $id ) {
    // update the user #id, using PUT method
  }

  public static function destroy( $id ) {
    // delete the user #id, using DELETE method
  }
}

?>
