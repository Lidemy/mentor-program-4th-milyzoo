<?php
  session_start();
  require_once('_conn.php');
  require_once('_check_permission.php');

  $title = $_POST['post-title'];
  $content = $_POST['post-content'];
  $category_id = $_POST['category_id'];
  if (
    empty($title) ||
    empty($content) ||
    empty($category_id)
  ) {
    header('Location: admin_add_article.php?errCode=1');
    die();
  }

  $sql = 'INSERT INTO mily_blog_articles(title, content, category_id) VALUES(?,?,?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssi', $title, $content, $category_id); // 把參數放進去，有幾個字就有幾個 s (s 代表 string，如果要放整數就寫 i，代表 int)
  $result = $stmt->execute();
  // 判斷如果不成功
  if (!$result) {
    die(print_r($conn->error));
  }

  // 成功就導回頁面
  header('Location: admin_article_management.php');
?>