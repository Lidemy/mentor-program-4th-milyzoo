<?php
  require_once('_conn.php');
  
  function getUserFromUsername($username) {
    global $conn;
    $sql = sprintf(
      'SELECT * FROM mily_users WHERE username = "%s"',
      $username
    );
    $result = $conn->query($sql);
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