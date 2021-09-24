<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div id="header">
    <h1><a href="<?php echo $base_url; ?>/">mini blog</a></h1>
  </div>
  <div id="nav">
    <p>
      <?php if ($session->isAuthenticated()): ?>
        <a href="<?php echo $base_url; ?>/">ホーム</a>
        <a href="<?php echo $base_url; ?>/account">アカウント</a>
      <?php else: ?>
        <a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
        <a href="<?php echo $base_url; ?>/account/signup">アカウント登録</a>
      <?php endif; ?>
    </p>
  </div>
  <div id="main">
    <?php echo $_content; ?>
  </div>
</body>
</html>