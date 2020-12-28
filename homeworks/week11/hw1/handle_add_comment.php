<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  if (empty($_POST['content'])) { // 如果欄位有缺
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
  $avatar = $_POST['avatar'];
  $is_hidden = $_POST['is_hidden'];

  // 如果沒有權限就會導回首頁
  if (!hasPermission($user, 'create', NULL)) {
    header('Location: index.php');
    exit();
  }

  $content = $_POST['content'];
  $sql = 'INSERT INTO mily_comments(username, content, avatar, is_hidden) VALUES(?, ?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssss', $username, $content, $avatar, $is_hidden); // 把參數放進去，有幾個字就有幾個 s (s 代表 string，如果要放整數就寫 i，代表 int)
  $result = $stmt->execute();
  if (!$result) {
    die(print_r($conn->error));
  }

  header('Location: index.php');
?>