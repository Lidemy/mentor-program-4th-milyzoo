<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $username = NULL;
  $user = NULL;
  if(!empty($_SESSION['username'])) { // 判斷如果 $token 不是空的，就是登入狀態
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  } else {
    header('Location: index.php');
    die('登入後才能編輯會員資料');
  }

  $stmt = $conn->prepare('SELECT * FROM mily_comments ORDER BY id desc');
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
  $result = $stmt->get_result(); // 用了 $stmt 後，要再加上這一行才會把結果拿回來
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
        <p class="nav__nickname">Hi，<?php echo escape($user['nickname']);?></p>
        <?php if ($user && $user['role'] === 'ADMIN') { ?>
          <a class="nav__item" href="admin.php"><img class="nav__item-icon" src="images/admin.svg">管理後台</a>
        <?php } ?>
        <a class="nav__item" href="update_user.php"><img class="nav__item-icon" src="images/user-edit.svg">修改資料</a>
        <a class="nav__item" href="logout.php"><img class="nav__item-icon" src="images/signin.svg">登出</a>
      <?php } ?>
      </div>
      <div class="nav__menu-btn"></div>
    </div>
  </nav>
  <div class="container">
    <section class="background">
        <form method="POST" action="handle_update_user.php">
            <?php
              if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                $msg = 'Error';
                if ($code === '2') {
                  $msg = '暱稱已經被使用過囉！';
                }
                echo '<p class="error-update-user">錯誤：' . $msg . '</p>';
              }
            ?>
            <div class="update-user">
                <p class="update__title">原本暱稱：</p>
                <?php $row = $result->fetch_assoc() ?>
                <p><?php echo escape($user['nickname']);?></p>
            </div>
            <label class="input-title">
                <span class="update__title">新的暱稱：</span>
                <input class="update-user__input" type="text" name="nickname" />
            </label>
            <button class="register__btn" type="submit">確定修改</button>
        </form>
    </section>
  </div>
  <script src="main.js"></script>
</body>
</html>