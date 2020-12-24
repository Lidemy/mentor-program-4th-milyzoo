<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');
  require_once('_check_permission.php');
  
  $id = intval($_GET['id']);
  if (empty($id)) { // 如果 $id 是空的
    header('Location: error.php'); // 就導到錯誤頁面
    die();
  }
  
  $sql = 'SELECT * FROM mily_blog_articles WHERE id = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
  $result = $stmt->get_result(); // 用了 $stmt 後，要再加上這一行才會把結果拿回來
  $row = $result->fetch_assoc();
  if ($row == null) { // 如果資料庫找不到這個編號 id
    header('Location: error.php'); // 就導到錯誤頁面
    die();
  }
  
  $sql_category = 'SELECT * FROM mily_blog_categories ORDER BY created_at DESC';
  $result_category = $conn->query($sql_category);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>編輯文章 - 管理後台</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <header class="header">
      <nav class="navbar">
        <a class="navbar__logo" href='admin.php'>管理後台</a>
        <ul class="navbar__list">
          <li><a href="admin_article_management.php">文章管理</a></li>
          <li><a href="admin_category.php">分類管理</a></li>
          <li><a class="btn__admin" href="login.php">登出</a></li>
        </ul>
      </nav>
    </header>

    <div class="main-min-height">
      <main class="main-background">
        <form class="edit-post" action="handle_update_article.php" method="POST">
          <h2 class="title-admin"><span class="material-icons">edit</span>編輯文章</h2>
          <div class="edit-post__title">
            <div class="edit-post__select">
              <select name="category_id">
                <?php while($row_category = $result_category->fetch_assoc()) { ?>
                  <option value="<?php echo escape($row_category['id'])?>"
                  <?php echo escape($row['category_id']) == escape($row_category['id'])? "selected" : ""; ?>>
                  <?php echo escape($row_category['name']); ?></option>
                <?php } ?>
              </select>
            </div>
            <input class="edit-post__input" type="text" name="title" value="<?php echo escape($row['title']); ?>" />
          </div>
          <textarea rows="25" class="edit-post__content" name="content"><?php echo escape($row['content']); ?></textarea>
          <input type="hidden" name="id" value="<?php echo escape($row['id']); ?>"/>
          <input type="hidden" name="page" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
          <input class="btn__edit-post" type="submit" value="送出">
        </form>
      </main>
    </div>

    <footer class="footer">
      <div class="container">
          <p>Copyright © Mily's Blog All Rights Reserved.
      </div>
    </footer>
  </div>
</body>
</html>