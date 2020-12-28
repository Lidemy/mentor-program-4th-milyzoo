<?php
  session_start();
  require_once('_conn.php');

  $username = NULL;
  if(!empty($_SESSION['username'])) { // 判斷如果 $token 不是空的，就是登入狀態
    $username = $_SESSION['username'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>今天吃什麼 ლ(´ڡ`ლ)</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <nav class="nav nav__menu-active">
    <div class="nav__content">
      <a class="logo" href="index.php">今天吃什麼<span>ლ(´ڡ`ლ)</span></a>
      <div class="nav__list">
        <?php if (!$username) { ?>
          <a class="nav__item" href="register.php"><img class="nav__item-icon" src="images/signup.svg">註冊</a>
          <a class="nav__item" href="login.php"><img class="nav__item-icon" src="images/signin.svg">登入</a>
        <?php } else { ?>
        <a class="nav__item" href="update_user.php"><img class="nav__item-icon" src="images/user-edit.svg">修改資料</a>
          <a class="nav__item" href="logout.php"><img class="nav__item-icon" src="images/signin.svg">登出</a>
        <?php } ?>
      </div>
      <div class="nav__menu-btn"></div>
    </div>
  </nav>
  <div class="container">
    <div class="register register-done">
      <h1 class="register__title">註冊完成</h1>
      <p>恭喜您，註冊成功！</p>
      <p>快和大家一起交流吧 (*•̀ᴗ•́*)و </p>
      <a href="index.php" class="register__btn">留言去</a>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>