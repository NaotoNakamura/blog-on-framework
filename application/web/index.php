<?php

require '../bootstrap.php';
require '../MiniBlogApplication.php';
$routes = require '../routes/routes.php';

$app = new MiniBlogApplication(true, dirname(__DIR__), $routes);
$app->run();


/*
処理の流れ
1. MiniBlogApplicationを実体化

2. Applicationクラスで以下のクラスを実体化し、クラス変数に保存
- Request
- Response
- Session
- DbManager
- Router（コンストラクタ引数にMiniBlogApplicationで定義したルーティング配列を受け取る）

3. Applicationクラスのrunメソッドを実行

4. リクエストされたパスをRequestクラスから取得し、その情報をRouterに渡す

5. リクエストされたパスに一致するルーティングがあればマッチしたcontrollerとactionを返す

6. マッチしたcontrollerを実体化
この際、ApplicationクラスのRequest、Response、Session、DbManager、Routerを引き渡す

7. マッチしたactionを実行

8. 実行結果をresponseにセット

9. レスポンス結果を返す

*/