<?php
  require_once('conn.php');

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
  $password = $_POST['password'];

  $sql = sprintf(
    "INSERT INTO mily_users(nickname, username, password) VALUES('%s', '%s', '%s')",
    $nickname,
    $username,
    $password
  );
  
  $result = $conn->query($sql);
  if (!$result) {
    $code = $conn->errno;
    if ($code === 1062) {
        header("Location: register.php?errCode=2");
    }
    die(print_r($conn->error));
  }

  header("Location: register_done.php");
?>