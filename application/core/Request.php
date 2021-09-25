<?php
namespace core;

class Request
{
  public function isPost()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return true;
    }
    return false;
  }
  
  public function getGet($name, $default = null)
  {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $default;
  }

  public function getPost($name, $default = null)
  {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $default;
  }

  // ex)localhost:8080
  public function getHost()
  {
    if (!empty($_SERVER['HTTP_HOST'])) {
      
      return $_SERVER['HTTP_HOST'];
    }
    return $_SERVER['SERVER_NAME'];
  }

  public function isSsl()
  {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      return true;
    }
    return false;
  }

  public function getRequestUri()
  {
    return $_SERVER['REQUEST_URI'];
  }

  /*
    どこからどこまでがindex.phpまでのURLかを返す
    index.phpまでのURLを取得（index.phpもリクエストされた場合はそれも含む）
    例）https://example.com/foo/bar/list（foo/bar以下にindex.phpがある場合）
    /foo/bar
  */
  public function getBaseUrl()
  {
    /* 
      index.phpまでのパス（index.phpも含む）
      例）https://example.com/foo/bar/list（foo/bar以下にindex.phpがある場合）
      /foo/bar/index.php
    */
    $script_name = $_SERVER['SCRIPT_NAME'];

    // リクエストされたURL
    $request_uri = $this->getRequestUri();

    // index.phpがリクエストに含まれる場合はscript_nameをそのまま返す
    if (0 === strpos($request_uri, $script_name)) {
      return $script_name;
    // index.phpがリクエストに含まれない場合はscript_nameからindex.phpを除いたものを返す
    } else if (0 === strpos($request_uri, dirname($script_name))) {
      return rtrim(dirname($script_name), '/');
    }
    return '';
  }

  // リクエストされたパスを返す（REQUEST_URIからbaseUrlを取り除いた値）
  public function getPathInfo()
  {
    $base_url = $this->getBaseUrl();
    $request_uri = $this->getRequestUri();

    // ?があれば（$posでは?が最初に現れる場所を取得）
    if (false !== ($pos = strpos($request_uri, '?'))) {
      // ?以降のパラメータを削除（第二引数で指定した部分から第三引数で指定した文字数分取得）
      $request_uri = substr($request_uri, 0, $pos);
    }

    $path_info = (string)substr($request_uri, strlen($base_url));
    return $path_info;
  }
}
