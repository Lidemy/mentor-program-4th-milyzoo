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
  
  $sql = 'SELECT * FROM mily_blog_categories WHERE id = ?';
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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>編輯分類 - 管理後台</title>
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
      <main class="main-background admin-category">
        <h1>編輯分類</h1>
        <form class="admin-category__update-category" action="handle_update_category.php" method="POST">
          <input class="admin-category__input" id="category" name="category" value="<?php echo escape($row['name']); ?>">
          <input type="hidden" name="id" value="<?php echo escape($row['id']); ?>"/>

          <div class="admin-category__actions">
            <input class="btn__admin" type="submit" value="確定">
            <a class="btn__admin" href="admin_category.php">取消</a>
          </div>
        </form>
      </main>
    </div>
    
    <footer class="footer">
      <div class="container">
          <p>Copyright © Mily's Blog All Rights Reserved.</p>
      </div>
    </footer>
  </div>
</body>
</html>