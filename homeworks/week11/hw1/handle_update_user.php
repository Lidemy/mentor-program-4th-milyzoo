<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $username = $_SESSION['username'];
  $nickname = $_POST['nickname'];

  if (empty($nickname)) { // 如果欄位有缺
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  // 檢查沒問題再更新暱稱
  $sql = 'UPDATE mily_users SET nickname = ? WHERE username = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $nickname, $username); // 把參數放進去
  $result = $stmt->execute();
  if (!$result) {
    $code = $conn->errno;
    if ($code === 1062) { // 1062 代表和資料表的值有重複
        header('Location: update_user.php?errCode=2');
    }
    die(print_r($conn->error));
  }
  
  header('Location: update_user.php');
?>