<?php
  session_start();
  require_once('_conn.php');
  require_once('_check_permission.php');

  $category = $_POST['category'];
  if (empty($category)) {
    header('Location: admin_category.php?errCode=1');
    die();
  }

  $sql = 'INSERT INTO mily_blog_categories(name) VALUES(?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $category); // 把參數放進去，有幾個字就有幾個 s (s 代表 string，如果要放整數就寫 i，代表 int)
  $result = $stmt->execute();
  // 判斷如果不成功
  if (!$result) {
    die(print_r($conn->error));
  }

  // 成功就導回頁面
  header('Location: admin_category.php');
?>