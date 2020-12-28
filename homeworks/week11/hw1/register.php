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
        <a class="nav__item" href="register.php"><img class="nav__item-icon" src="images/signup.svg">註冊</a>
        <a class="nav__item" href="login.php"><img class="nav__item-icon" src="images/signin.svg">登入</a>
      </div>
      <div class="nav__menu-btn"></div>
    </div>
  </nav>
  <div class="container">
    <form class="background" method="POST" action="handle_register.php">
        <h1 class="register__title">註冊會員</h1>
        <?php
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = '錯誤：資料不齊全';
            } else if  ($code === '2') {
              $msg = '帳號或暱稱已被註冊';
            }
            echo '<h2 class="error-register">' . $msg . '</h2>';
          }
        ?>
        <label class="input-title"><span>帳號</span><input type="text" name="username" /></label>
        <label class="input-title"><span>密碼</span><input type="password" name="password" /></label>
        <label class="input-title"><span>暱稱</span><input type="text" name="nickname" /></label>
        <a href="login.php" class="login-signup-toggle">已經有帳號了？按此登入</a>
        <button class="register__btn" type="submit">送出</button>
    </form>
    <div class="warning">注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</div>
  </div>
  <script src="main.js"></script>
</body>
</html>