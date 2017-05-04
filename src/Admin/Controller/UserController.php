<?php

namespace Admin\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Taakin\Models\User;

/**
 *
 */
class UserController {

  private static $action = '';
  private static $data = [];

  public static function index( Application $app ) {

    return $app['twig']->render('admin/user-list.twig', self::$data );
  }

  public static function edit( $id ) {
    // show edit form
  }

  public static function show( Application $app, $id ) {
    // show the user #id

  }

  public static function store( Request $request, Application $app ) {
    // create a new user, using POST method
    self::$action = $app['url_generator']->generate( 'create-user' );
    $form = self::_form( $app );
    $form->handleRequest( $request );

    if ( $form->isValid() ) {

      $data = $form->getData();
      $user = new User();

      foreach ($data as $key => $value)
        $customer->{$key} = $value;

      if ( ! $user->save() ) {
        $redirect = $app['url_generator']->generate( 'user-list' );
        return $app->redirect( $redirect );
      }
    }


    self::$data['form'] = $form->createView();
    return $app['twig']->render('admin/user-create.twig', self::$data );
  }

  public static function update( $id ) {
    // update the user #id, using PUT method
  }

  public static function destroy( $id ) {
    // delete the user #id, using DELETE method
  }

  private static function _form( Application $app ) {
    // create the form
    return $app['form.factory']->createBuilder( FormType::class )
      ->setAction( self::$action )
      ->setMethod( 'POST' )
      ->add( 'name' )
      ->add( 'first_name' )
      ->add( 'last_name' )
      ->add( 'username' )
      ->add( 'email', EmailType::class )
      ->add( 'password', PasswordType::class )
      ->add('submit', SubmitType::class, array(
        'label' => 'Save',
        'attr' => array(
          'class' => 'button float-right'
        )
      ) )
      ->getForm();
  }
}

?>
