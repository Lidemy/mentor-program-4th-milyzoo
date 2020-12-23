<?php
  session_start();
  require_once('_conn.php');
  require_once('_check_permission.php');

  $id = intval($_GET['id']);
  if (empty($id)) {
    header('Location: error.php');
    die();
  }

  $sql = 'UPDATE mily_blog_articles SET is_deleted = "1" WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id); // 把參數放進去 (i 代表 int)
  $result = $stmt->execute();
  if ($result) {
	  header('Location: admin_article_management.php');
	} else {
    die(print_r($conn->error));
	}
?>