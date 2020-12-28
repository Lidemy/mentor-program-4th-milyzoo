<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $id = $_GET['id'];
  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
  // $sql = "DELETE FROM mily_comments WHERE id = ?"; 如果要直接刪除就這麼寫 hard delete 的做法，假刪除就設置 is_deleted 欄位

  if (empty($id)) { // 如果欄位有缺
    header('Location: index.php');
    die('資料不齊全');
  }

  // 檢查沒問題再刪除 (for 會員)
  $sql = 'UPDATE mily_comments SET is_deleted = 1 WHERE id = ? AND username = ?'; // soft delete 的做法
  // 檢查沒問題再刪除 (for 管理員或共同編輯者)
  if (isAdmin($user) || isEditor($user)) {
    $sql = 'UPDATE mily_comments SET is_deleted = 1 WHERE id = ?';
  }
  $stmt = $conn->prepare($sql);
  if (isAdmin($user) || isEditor($user)) {
    $stmt->bind_param('i', $id); // 把參數放進去
  } else {
    $stmt->bind_param('is', $id, $username); // 把參數放進去
  }
 
  $result = $stmt->execute();
  if (!$result) {
    die(print_r($conn->error));
  }

  header('Location: index.php');
?>