<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
  $id = $_POST['id'];
  $role = $_POST['role'];

  if (empty($role)) {
    die('資料不齊全');
  }

  if (!$user || $user['role'] !== 'ADMIN') {
    header('Location: admin.php');
    exit();
  }

  $sql = 'UPDATE mily_users SET role = ? WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $role, $id); // 把參數放進去
  
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  
  header('Location: admin.php');
?>