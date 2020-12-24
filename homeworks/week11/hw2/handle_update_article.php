<?php
  session_start();
  require_once('_conn.php');
  require_once('_check_permission.php');

  $title = $_POST['title'];
  $content = $_POST['content'];
  $category_id = $_POST['category_id'];
  $id = $_POST['id'];
  $page = $_POST['page'];

  if (empty($title) || empty($content) || empty($category_id) || empty($id)) {
    header('Location: ' . $page);
    die('錯誤：內容不可空白');
  }

  $sql = 'UPDATE mily_blog_articles SET title = ?, content = ?, category_id = ? WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssii', $title, $content, $category_id, $id); // 把參數放進去，有幾個字就有幾個字母(s 代表 string，i 代表 int)
  $result = $stmt->execute();
  // 判斷如果不成功
  if (!$result) {
    die(print_r($conn->error));
  }

  // 成功就導回頁面
  header('Location:' . $page);
?>