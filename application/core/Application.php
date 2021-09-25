<?php

namespace core;
use core\Request;

abstract class Application {
  protected $debug = false;
  protected $request;
  protected $response;
  protected $session;
  protected $db_manager;
  protected $login_action = array();
  protected $rootDir;

  public function __construct($debug = false, $basePath = null, $routes = array())
  {
    $this->setDebugMode($debug);
    $this->initialize($routes);
    $this->configure();
    $this->rootDir = $basePath;
  }

  protected function setDebugMode($debug)
  {
    if ($debug) {
      $this->debug = true;
      ini_set('display_errors', 1);
      error_reporting(-1);
    } else {
      $this->debug = false;
      ini_set('display_errors', 0);
    }
  }

  protected function initialize($routes)
  {
    $this->request = new Request();
    $this->response = new Response();
    $this->session = new Session();
    $this->db_manager = new DbManager();
    $this->router = new Router($routes);
  }

  // 継承先でDB接続
  protected function configure()
  {

  }

  public function isDebugMode()
  {
    return $this->debug;
  }

  public function getRequest()
  {
    return $this->request;
  }

  public function getResponse()
  {
    return $this->response;
  }

  public function getSession()
  {
    return $this->session;
  }

  public function getDbManager()
  {
    return $this->db_manager;
  }

  public function getControllerDir()
  {
    return $this->rootDir . '/controllers';
  }

  public function getViewDir()
  {
    return $this->rootDir . '/views';
  }

  public function getModelDir()
  {
    return $this->rootDir . '/models';
  }

  public function getWebDir()
  {
    return $this->rootDir . '/web';
  }

  public function run()
  {
    try {
      $params = $this->router->resolve($this->request->getPathInfo());
      if ($params === false) {
        throw new HttpNotFoundException('No route found for ' . $this->request->getPathInfo());
      }
      $controller = $params['controller'];
      $action = $params['action'];
      $this->runAction($controller, $action, $params);
    } catch (HttpNotFoundException $e) {
      $this->render404Page($e);
    } catch (UnauthorizedActionException $e) {
      list($controller, $action) = $this->login_action;
      $this->runAction($controller, $action);
    }

    $this->response->send();
  }

  public function runAction($controller_name, $action, $params = array())
  {
    $controller_class = ucfirst($controller_name) . 'Controller';
    $controller = $this->findController($controller_class);
    if ($controller === false) {
      throw new HttpNotFoundException($controller_class . ' controller is not found.');
    }
    $content = $controller->run($action, $params);
    $this->response->setContent($content);
  }

  protected function findController($controller_class)
  {
    if (!class_exists($controller_class)) {
      $controller_file = $this->getControllerDir() . '/' . $controller_class . '.php';
      if (!is_readable($controller_file)) {
        return false;
      } else {
        require_once $controller_file;
        if (!class_exists($controller_class)) {
          return false;
        }
      }
    }
    return new $controller_class($this);
  }

  protected function render404Page($e)
  {
    $this->response->setStatusCode(404, 'Not Found');
    $message = $this->isDebugMode() ? $e->getMessage() : 'Page not found.';
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $this->response->setContent(<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>404</title>
</head>
<body>
    {$message}
</body>
</html>
EOF
    );
  }
}