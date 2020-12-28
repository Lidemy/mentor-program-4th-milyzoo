<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $id = $_GET['id']; // 網址上的 id

  $username = NULL;
  $user = NULL;
  if(!empty($_SESSION['username'])) { // 判斷如果 $token 不是空的，就是登入狀態
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  $sql = 'SELECT * FROM mily_comments WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id); // i 代表 int

  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
  $result = $stmt->get_result(); // 用了 $stmt 後，要再加上這一行才會把結果拿回來
  $row = $result->fetch_assoc();
  if (empty($row)) {
    header('Location: index.php');
    die('此則留言不存在');
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
      <?php if ($username) { // 如果有登入就顯示以下 ?>
        <h2 class="title"><img src="images/comment-edit.svg">編輯留言</h2>
        <form class="board" method="POST" action="handle_update_comment.php">
          <div class="board__content">
            <?php
              if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                $msg = 'Error';
                if ($code === '1') {
                  $msg = '修改內容不能空白喔！';
                }
                echo '<p class="error-update_comment">錯誤：' . $msg . '</p>';
              }
            ?>
            <textarea class="board__textarea" name="content"><?php echo escape($row['content']); ?></textarea>
          </div>
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> 
          <!-- 隱藏的 input，用來取得 網址上的 id -->
          <div class="update-comment__btn modal modal-hide">
            <div class="btn board__cancel-edit">取消修改</div>
            <button class="board__submit" type="submit">確定修改<img src="images/send.svg"></button>

            <!-- 確認放棄編輯 -->
            <div class="modal-box">
              <div class="modal__content">
                <span class="modal__close">&times;</span>
                <h3>確定要捨棄編輯的留言嗎？</h3>
                <p>如果確定捨棄，剛才編輯的內容將會消失</p>
                <div class="modal__action">
                  <p class="btn modal__cancel">繼續編輯</p>
                  <a class="btn" href="index.php">確定捨棄</a>
                </div>
              </div>
            </div>

          </div>
        </form>
      <?php
        } else if (!$username) { // 如果沒有登入就導回登入頁面
          header("Location: login.php");
          die('請先登入再編輯留言');
        }
      ?>
  </div>
  <script src="main.js"></script>
  <script>
    // 捨棄編輯留言的 modal
    const editButton = document.querySelector('.board__cancel-edit')
    modalAction('.modal', editButton);
  </script>
</body>
</html>