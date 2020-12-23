<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');
  require_once('_check_permission.php');
  
  $sql = 'SELECT * FROM mily_blog_articles WHERE is_deleted ="0" ORDER BY created_at DESC';
  $result = $conn->query($sql);
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>文章管理 - 管理後台</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <?php include_once('_admin_header.php') ?>

    <div class="main-min-height">
      <main class="main-background">
        <ul class="admin-article__list">
          <?php if ($result->num_rows == 0) { ?>
            <li class="admin-article__empty-item">目前沒有文章</li>
          <?php } ?>
          <?php while($row = $result->fetch_assoc()) { ?>
            <li class="admin-article__item">
              <div class="admin-article__created-at"><?php echo escape(date('Y / m / d',strtotime($row['created_at']))); ?></div>              
              <a class="admin-article__title" href="admin_article.php?id=<?php echo escape($row['id']) ?>"><?php echo escape($row['title']); ?></a>
              <div class="article__actions admin-article__actions">
                <a class="btn__admin" href="admin_update_article.php?id=<?php echo escape($row['id']); ?>">編輯</a>
                <a class="btn__admin" href="handle_delete_article.php?id=<?php echo escape($row['id']); ?>">刪除</a>
              </div>
            </li>
          <?php } ?>
        </ul>
      </main>
    </div>
    
    <a href="admin_add_article.php" class="add-post-btn">
      <span class="material-icons">post_add</span>
    </a>
    
    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>