<?php
namespace Admin\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Taakin\Models\User;

/**
 *
 */
class IndexController {

  private static $action = '';
  private static $data = [];

  public static function index( Request $request, Application $app ) {

    if ( null != $app['session']->get('user_id') )
      return $app->redirect('/dashboard/');

    self::$action = $app['url_generator']->generate( 'login' );
    $form = $app['form.factory']->createBuilder( FormType::class )
      ->setAction( self::$action )
      ->setMethod( 'POST' )
      ->add( 'email', EmailType::class )
      ->add( 'password', PasswordType::class )
      ->add( 'submit', SubmitType::class, array(
        'label' => 'Sign In',
      ) )
      ->getForm();

    $form->handleRequest( $request );

    if ( $form->isValid() ) {

      $data = $form->getData();
      $user = User::where( 'email', $data['email'] )
        ->where( 'password', md5( $data['password'] ) )
        ->get();

      if ( ! $user->isEmpty() ) {
        $user = $user->first();
        $app['session']->set('user_id', $user->id);
        $app['session']->set('email', $user->email);
        $app['session']->set('username', $user->username);
        return $app->redirect('/dashboard/');
      }
    }

    self::$data['form']= $form->createView();
    return $app['twig']->render('admin/home.twig', self::$data );
  }

  public static function logout( Request $request, Application $app ) {
    $app['session']->clear();

    return $app->redirect('/');
  }

  public static function dashboard( Request $request, Application $app ) {

    if ( null === $app['session']->get('user_id') )
      return $app->redirect('/');

    self::$data['baseUrl'] = $request->getRequestUri();
    return $app['twig']->render('admin/dashboard.twig', self::$data );
  }
}

?>
