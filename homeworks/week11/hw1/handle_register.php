<?php
  session_start();
  require_once('_conn.php');

  if (
    empty($_POST['username']) ||
    empty($_POST['password']) ||
    empty($_POST['nickname'])
  ) {
    header("Location: register.php?errCode=1");
    die();
  }

  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  // 使用 password_hash() 後，存到資料庫的密碼就被處理成雜湊密碼了

  $sql = 'INSERT INTO mily_users(nickname, username, password) VALUES(?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $nickname, $username, $password); // 把參數放進去
  $result = $stmt->execute();
  if (!$result) {
    $code = $conn->errno;
    if ($code === 1062) { // 1062 代表和資料表的值有重複
        header('Location: register.php?errCode=2');
    }
    die(print_r($conn->error));
  }

  $_SESSION['username'] = $username; // 註冊完直接登入
  header('Location: register_done.php');
?>