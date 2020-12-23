<?php
  session_start();
  require_once('_conn.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登入後台 - 管理後台</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <header class="header">
      <nav class="navbar">
        <a class="navbar__logo" href='login.php'>管理後台</a>
        <ul class="navbar__list">
          <li><a class="btn__admin" href="index.php">回部落格</a></li>
        </ul>
      </nav>
    </header>

    <div class="main-min-height">
      <section class="login">
        <form action="handle_login.php" method="POST">
          <h1 class="title-main text-center">登入後台</h1>
          <?php
            if (!empty($_GET['errCode'])) {
              $code = $_GET['errCode'];
              $msg = 'Error';
              if ($code === '1') {
                $msg = '資料不齊全';
              } else if  ($code === '2') {
                $msg = '帳號或密碼輸入錯誤';
              }
              echo '<p class="error-message">錯誤：' . $msg . '</p>';
            }
          ?>
          <div class="input__wrapper">
            <span class="material-icons">person</span>
            <input class="input__field" type="text" name="username" placeholder="帳號" />
          </div>
          <div class="input__wrapper">          
            <span class="material-icons">lock</span>
            <input class="input__field" type="password" name="password" placeholder="密碼" />
          </div>
          <input class="btn__submit" type='submit' value="登入" />
        </form>
      </section>
    </div>

    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>