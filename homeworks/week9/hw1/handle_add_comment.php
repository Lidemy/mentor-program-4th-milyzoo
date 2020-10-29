<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (
      empty($_POST['content'])
  ) {
    header("Location: index.php?errCode=1");
    die('資料不齊全');
  }

  $user = getUserFromUsername($_SESSION['username']);
  $nickname = $user['nickname'];

  $content = $_POST['content'];
  $sql = sprintf(
    "INSERT INTO mily_comments(nickname, content) VALUES('%s', '%s')",
    $nickname ,
    $content
  );
  
  echo 'SQL' . $sql . '<>';
  $result = $conn->query($sql);

  if (!$result) {
    die(print_r($conn->error));
  }

  header("Location: index.php");
?>