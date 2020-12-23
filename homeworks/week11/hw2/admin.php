<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');
  require_once('_check_permission.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理後台</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <?php include_once('_admin_header.php') ?>

    <div class="main-min-height">
      <main class="admin">
        <a class="main-background" href="admin_article_management.php">
          <span class="material-icons">article</span>
          <p>文章管理</p>
        </a>
        <a class="main-background" href="admin_category.php">
          <span class="material-icons">folder_open</span>
          <p>分類管理</p>
        </a>
      </main>
    </div>

    <a href="admin_add_article.php" class="add-post-btn">
      <span class="material-icons">post_add</span>
    </a>

    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>