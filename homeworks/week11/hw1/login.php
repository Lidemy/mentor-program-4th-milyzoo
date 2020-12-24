<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>今天吃什麼 ლ(´ڡ`ლ)</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="main.css">
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
    <form class="register" method="POST" action="handle_login.php">
        <h1 class="register__tittle">登入會員</h1>
        <?php
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = '錯誤：資料不齊全';
            } else if  ($code === '2') {
              $msg = '帳號或密碼輸入錯誤';
            }
            echo '<h2 class="error-register">' . $msg . '</h2>';
          }
        ?>
        <label class="board__input-tittle"><span>帳號</span><input type="text" name="username" /></label>
        <label class="board__input-tittle"><span>密碼</span><input type="password" name="password" /></label>
        <a href="register.php" class="login-signup-toggle">還沒有帳號嗎？按此註冊</a>
        <button class="register__btn" type="submit">登入</button>
    </form>
  </div>
  <script src="main.js"></script>
</body>
</html>