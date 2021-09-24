<?php

class Router
{
  protected $routes;

  // ルーティング定義の配列を受け取る（各アプリから受け取るもの）
  public function __construct($definitions)
  {
    $this->routes = $this->compileRoutes($definitions);
  }

  /*
    ルーティング定義内の動的パラメータを正規表現で扱える形式に変換
  */
  public function compileRoutes($definitions)
  {
    $routes = array();

    foreach ($definitions as $url => $params) {
      // ルーティング定義のキー（URL部分）を「/」ごとに分割
      $tokens = explode('/', ltrim($url, '/'));
      foreach ($tokens as $i => $token) {
        // 「:」が存在したら
        if (0 === strpos($token, ':')) {
          // 「:」を取り除く
          $name = substr($token, 1);
          $token = '(?P<' . $name . '>[^/]+)';
        }
        $tokens[$i] = $token;
      }
      // 「/」で再度つなげる
      $pattern = '/' . implode('/', $tokens);
      $routes[$pattern] = $params;
    }
    return $routes;
  }

  // compileRoutes()で変換したルーティング定義配列とpath_infoのマッチングを行う
  public function resolve($path_info) {

    // 先頭にスラッシュがない場合はスラッシュを付与
    if ('/' !== substr($path_info, 0, 1)) {
      $path_info = '/' . $path_info;
    }

    foreach ($this->routes as $pattern => $params) {
      // $path_infoがルーティング定義配列のキーの正規表現にマッチすれば
      if (preg_match('#^' . $pattern . '$#', $path_info, $matches)) {
        // ルーティング定義配列の値とマッチ結果の配列を合体
        $params = array_merge($params, $matches);
        return $params;
      }
    }
    return false;
  }
}

/*
1. 以下のリクエスト
/item/1

2. ルーティング定義配列
$routing = array(
  '/item/:id' => array('controller' => 'item')
)

3. 以下を実行すると
compileRoutes($routing)

4. 以下が返却
$compiledRouting = array(1) {
  ["/item/(?P<id>[^/]+)"]=>
  array(1) {
    ["controller"]=>
    string(4) "item"
  }
}

5. 以下を実行すると
resolve($compiledRouting)

6. 以下が返却
array(4) {
  ["controller"]=>
  string(4) "item"
  [0]=>
  string(7) "/item/1"
  ["id"]=>
  string(1) "1"
  [1]=>
  string(1) "1"
}

*/
