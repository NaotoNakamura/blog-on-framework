<?php

class ClassLoader
{
    protected $dirs;

    public function register() {
      // 引数にインスタンスを渡すには配列の0番目の要素にオブジェクト、1番目の要素にメソッド名を指定
      spl_autoload_register(array($this, 'loadClass'));
    }

    public function registerDir($dir) {
      $this->dirs[] = $dir;
    }

    public function loadClass($class) {
      foreach ($this->dirs as $dir) {
        $file = $dir . '/' . $class . '.php';
        if (is_readable($file)) {
          require $file;
          return;
        }
      }
    }

}
