<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) { // 判斷如果 $token 不是空的，就是登入狀態
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  // 不是管理員就導回首頁
  if ($user === NULL || $user['role'] !== 'ADMIN') {
    header('Location: index.php');
    die('管理員才能進入後台');
  }

  // 條件需排除最高權限 ADMIN 的使用者
  $sql = 'SELECT id, nickname, username, created_at, role FROM mily_users WHERE role <> "ADMIN" ORDER BY id ASC';
  $stmt = $conn->prepare($sql);
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
    <title>後台管理</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <nav class="nav nav__menu-active">
    <div class="nav__content">
      <a class="logo" href="index.php">今天吃什麼<span>ლ(´ڡ`ლ)</span></a>
      <div class="nav__list">
      <?php if ($username) { ?>
        <p class="nav__nickname">Hi，<?php echo escape($user['nickname']);?></p>
        <a class="nav__item" href="admin.php"><img class="nav__item-icon" src="images/admin.svg">管理後台</a>
        <a class="nav__item" href="update_user.php"><img class="nav__item-icon" src="images/user-edit.svg">修改資料</a>
        <a class="nav__item" href="logout.php"><img class="nav__item-icon" src="images/signin.svg">登出</a>
      <?php } ?>
      </div>
      <div class="nav__menu-btn"></div>
    </div>
  </nav>
  <div class="container">
    <ul class="user-table">
        <li class="user-table__thead">
          <ol class="user-table__item">
            <li>編號</li>
            <li>帳號</li>
            <li>暱稱</li>
            <li>創建日期</li>
            <li>權限</li>
          </ol>
        </li>
        <li class="user-table__tbody">
          <?php while($row = $result->fetch_assoc()) { ?>
            <ol class="user-table__item">
              <li data-title="編號" class="user-table__id"><?php echo escape($row['id']); ?></li>
              <li data-title="帳號"><?php echo escape($row['username']); ?></li>
              <li data-title="暱稱"><?php echo escape($row['nickname']); ?></li>
              <li data-title="創建日期"><?php echo escape(date('Y-m-d',strtotime($row['created_at']))); ?></li>
              <li data-title="權限" class="user-table__role">
                <form method="POST" action="handle_update_role.php">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <div class="user-table__select">
                    <select name="role">
                      <option <?php echo $row['role'] == "EDITOR"? 'selected':'' ?> value="EDITOR">共同編輯者</option>
                      <option <?php echo $row['role'] == "NORMAL"? 'selected':'' ?> value="NORMAL">一般使用者</option>
                      <option <?php echo $row['role'] == "BLOCKLIST"? 'selected':'' ?> value="BLOCKLIST">停權使用者</option>
                    </select>
                  </div>
                  <button type="submit" class="user-table__submit">修改</button>
                </form>
              </li>
            </ol>
          <?php } ?>
        </li>
    </ul>
  </div>
  <script src="main.js"></script>
</body>
</html>