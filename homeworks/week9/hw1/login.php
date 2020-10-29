<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>今天吃什麼 ლ(´ڡ`ლ)</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="nav">
    <div class="nav__content">
      <a href="index.php" class="logo">今天吃什麼<span>ლ(´ڡ`ლ)</span></a>
      <div class="nav__list">
        <a href="register.php" class="nav__item"><img class="nav__item-icon" src="images/signup.svg">註冊</a>
        <a href="login.php" class="nav__item"><img class="nav__item-icon" src="images/signin.svg">登入</a>
      </div>
    </div>
  </nav>
  <main class="main">
    <form class="register" method="POST" action="handle_login.php">
        <h1 class="register__tittle">登入會員</h1>
        <?php
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = '資料不齊全 ( ･ᴗ･̥̥̥ )';
            } else if  ($code === '2') {
              $msg = '帳號或密碼輸入錯誤';
            }
            echo '<h2 class="error-register">錯誤：' . $msg . '</h2>';
          }
        ?>
        <label class="board__input-tittle"><span>帳號</span><input type="text" name="username" /></label>
        <label class="board__input-tittle"><span>密碼</span><input type="password" name="password" /></label>
        <a href="register.php" class="login-signup-toggle">還沒有帳號嗎？按此註冊</a>
        <button class="register__btn" type="submit">登入</button>
    </form>
  </main>
</body>
</html>