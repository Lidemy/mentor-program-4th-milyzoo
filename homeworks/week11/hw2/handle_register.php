<?php
  require_once('_conn.php');
  session_start();

  if (
    empty($_POST['username']) ||
    empty($_POST['password'])
  ) {
    header('Location: register.php?errCode=1');
    die();
  }

  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  // 使用 password_hash() 後，存到資料庫的密碼就被處理成雜湊密碼了

  $sql = 'INSERT INTO mily_blog_users(username, password) VALUES(?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $username, $password); // 把參數放進去
  $result = $stmt->execute();
  if (!$result) {
    die(print_r($conn->error));
  }

  $_SESSION['username'] = $username; // 註冊完直接登入
  header('Location: admin.php');
?>