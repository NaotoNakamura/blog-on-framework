<?php

require "core/Application.php";
use core\Application;

class MiniBlogApplication extends Application {

  protected $login_action = array('account', 'signin');

}