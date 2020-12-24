<?php
  session_start();
  require_once('_conn.php');
  require_once('_check_permission.php');

  $id = $_GET['id'];
  $sql = 'DELETE FROM mily_blog_categories WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id); // 把參數放進去 (i 代表 int)
  $result = $stmt->execute();
  if ($result) {
	  header('Location: admin_category.php');
	} else {
    die(print_r($conn->error));
	}
?>