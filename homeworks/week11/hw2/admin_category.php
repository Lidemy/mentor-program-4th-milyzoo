<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');
  require_once('_check_permission.php');

  $sql = 'SELECT * FROM mily_blog_categories ORDER BY id ASC';
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
  <title>分類管理 - 管理後台</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <?php include_once('_admin_header.php') ?>

    <div class="main-min-height">
      <main class="main-background admin-category">
        <h1>分類管理</h1>
        <?php
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = '內容尚未填寫';
            }
            echo '<p class="error-message">錯誤：' . $msg . '</p>';
          }
        ?>
        <form class="admin-category__add-category" action="handle_add_category.php" method="POST">
          <input class="admin-category__input" id="category" name="category" type="text" placeholder="請輸入分類名稱">
          <button class="btn__admin" type="submit">新增</button>
        </form>
        <ul class="admin-category__list">
          <?php while($row = $result->fetch_assoc()) { ?>
            <li>
              <p><span class="material-icons">folder_open</span><?php echo escape($row['name']); ?></p>
              <div class="admin-category__actions">
                <a class="btn__admin" href="admin_update_category.php?id=<?php echo escape($row['id']) ?>">
                  <span class="material-icons icon-m">edit</span>
                  編輯
                </a>
                <a class="btn__admin" href="handle_delete_category.php?id=<?php echo escape($row['id']) ?>">
                  <span class="material-icons icon-m">delete_outline</span>
                  刪除
                </a>
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