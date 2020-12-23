<?php
  session_start();
  require_once('_conn.php');
  require_once('_check_permission.php');

  $category = $_POST['category'];
  $id = $_POST['id'];
  if (empty($category) || empty($id)) {
    die('錯誤：內容不可空白');
  }

  $sql = 'UPDATE mily_blog_categories SET name = ? WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $category, $id); // 把參數放進去，有幾個字就有幾個字母(s 代表 string，i 代表 int)
  $result = $stmt->execute();
  // 判斷如果不成功
  if (!$result) {
    die(print_r($conn->error));
  }

  // 成功就導回頁面
  header('Location: admin_category.php');
?>