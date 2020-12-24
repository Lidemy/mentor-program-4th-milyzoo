<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
  $id = $_POST['id'];
  $content = $_POST['content'];

  if (empty($content)) { // 如果欄位有缺
    header('Location: update_comment.php?errCode=1&id='.$_POST['id']);
    die('資料不齊全');
  }

  // 檢查沒問題再更新 (for 會員)
  $sql = 'UPDATE mily_comments SET content = ? WHERE id = ? AND username = ?';
  // 檢查沒問題再更新 (for 管理員或共同編輯者)
  if (isAdmin($user) || isEditor($user)) {
    $sql = 'UPDATE mily_comments SET content = ? WHERE id = ?';
  }
  $stmt = $conn->prepare($sql);
  if (isAdmin($user) || isEditor($user)) {
    $stmt->bind_param('si', $content, $id); // 把參數放進去
  } else {
    $stmt->bind_param('sis', $content, $id, $username); // 把參數放進去
  }
 
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php');
?>