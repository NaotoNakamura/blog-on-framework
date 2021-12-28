<?php 

namespace routes;

class Routes {

  public $login_action = array('account', 'signin');

  public function fetchRoutes()
  {
    return array(
      '/' => array('controller' => 'status', 'action' => 'index'),
      '/status/post' => array('controller' => 'status', 'action' => 'post'),
      '/user/:user_name' => array('controller' => 'status', 'action' => 'user'),
      '/user/:user_name/status/:id' => array('controller' => 'status', 'action' => 'show'),
      '/account' => array('controller' => 'account', 'action' => 'index'),
      '/account/:action' => array('controller' => 'account'),
    );
  }
}
