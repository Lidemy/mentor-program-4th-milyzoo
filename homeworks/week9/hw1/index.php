<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  
  /* 
    $username = $_SESSION['username']; 能做的事：
    1. 從 cookie 裡面讀取 PHPSESSID(token)
    2. 從檔案裡面讀取 session id 的內容
    3. 放到 $_SESSION
  */
  $username = NULL;
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }

  $result = $conn->query("SELECT * FROM mily_comments ORDER BY id desc");
  if (!$result) {
    die('Error:' . $conn->error);
  }
?>
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
      <?php if (!$username) { ?>
        <a href="register.php" class="nav__item"><img class="nav__item-icon" src="images/signup.svg">註冊</a>
        <a href="login.php" class="nav__item"><img class="nav__item-icon" src="images/signin.svg">登入</a>
      <?php } else { ?>
        <a href="logout.php" class="nav__item"><img class="nav__item-icon" src="images/signin.svg">登出</a>
      <?php } ?>
      </div>
    </div>
  </nav>
  <main class="main">
      <?php if ($username) { ?>
        <form class="board" method="POST" action="handle_add_comment.php">
          <?php
            if (!empty($_GET['errCode'])) {
              $code = $_GET['errCode'];
              $msg = 'Error';
              if ($code === '1') {
                $msg = '資料不齊全...( ･ᴗ･̥̥̥ )';
              }
              echo '<h2 class="error">錯誤：' . $msg . '</h2>';
            }
          ?>
          <label class="board__input-tittle"><textarea name="content" rows="5" placeholder="聊聊吃了什麼"></textarea></label>
          <button class="board__submit" type="submit">送出<img src="images/send.svg"></button>
        </form>
      <?php } else { ?>
        <div class="board board-guest">
          <p>立即登入發布留言</p>
          <a class="board-guest__btn" href="login.php">登入</a>
        </div>
      <?php } ?>
      <section class="comment">
        <?php
          while($row = $result->fetch_assoc()) {
        ?>
          <div class="card">
            <div class="card__info">
              <div class="card__avatar"></div>
              <div class="card__detail">
                  <p class="card__author"><?php echo $row['nickname']; ?></p>
                  <p class="card__time"><?php echo $row['created_at']; ?></p>
              </div>
            </div>
            <p class="card__message"><?php echo $row['content']; ?></p>
          </div>
        <?php } ?>
      </section>
  </main>
</body>
</html>