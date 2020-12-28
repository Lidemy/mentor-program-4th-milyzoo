<?php
  require_once('_conn.php');
  
  function getUserFromUsername($username) {
    global $conn;
    $sql = 'SELECT * FROM mily_users WHERE username = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username); // s 代表 string

    $result = $stmt->execute();
    if (!$result) {
      die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
    }
    $result = $stmt->get_result(); // 用了 $stmt 後，要再加上這一行才會把結果拿回來
    $row = $result->fetch_assoc();
    return $row; // 裡面有 username, id, nickname
  }

  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }

  // $action: update, delete, create
  function hasPermission($user, $action, $comment) {
    if ($user === NULL) {
      return;
    }
    if ($user['role'] === 'ADMIN') {
      return true;
    }
    if ($user['role'] === 'EDITOR') {
      return true;
    }
    if ($user['role'] === 'NORMAL') {
      if ($action === 'create') return true;
      return $comment['username'] === $user['username'];
    }
    if($user['role'] === 'BLOCKLIST') {
      if ($action === 'create') return false;
      return $comment['username'] === $user['username'];
      // 停權者不能留言，但可以編輯及刪除自己的留言
    }
  }

  function isAdmin($user) {
    return ($user['role'] === 'ADMIN');
  }
  function isEditor($user) {
    return ($user['role'] === 'EDITOR');
  }
?>