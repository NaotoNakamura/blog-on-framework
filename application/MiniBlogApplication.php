<?php

class MiniBlogApplication extends Application {

  protected $login_action = array('account', 'signin');

  public function registerRoutes()
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

  public function configure()
  {
    $this->db_manager->connect('master', array(
      'dsn' => 'mysql:dbname=framework_db;host=db',
      'user' => 'root',
      'password' => 'secret',
    ));
  }
}