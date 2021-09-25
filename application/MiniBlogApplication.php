<?php

require "core/Application.php";
use core\Application;

class MiniBlogApplication extends Application {

  protected $login_action = array('account', 'signin');

  public function configure()
  {
    $this->db_manager->connect('master', array(
      'dsn' => 'mysql:dbname=framework_db;host=db',
      'user' => 'root',
      'password' => 'secret',
    ));
  }
}