<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');
  require_once('_check_permission.php');

  $sql = 'SELECT * FROM mily_blog_categories ORDER BY id ASC';
  $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>發佈文章 - 管理後台</title>
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
        <form class="edit-post" action="handle_add_article.php" method="POST">
          <h2 class="title-admin"><span class="material-icons">post_add</span>發佈文章</h2>
          <?php
            if (!empty($_GET['errCode'])) {
              $code = $_GET['errCode'];
              $msg = 'Error';
              if ($code === '1') {
                $msg = '內容不得為空白';
              }
              echo '<p class="error-message">錯誤：' . $msg . '</p>';
            }
          ?>
          <div class="edit-post__title">
            <div class="edit-post__select">
              <select name="category_id">
                <?php while($row = $result->fetch_assoc()) { ?>
                  <option value="<?php echo escape($row['id']) ?>"><?php echo escape($row['name']); ?></option>
                <?php } ?>
              </select>
            </div>
            <input class="edit-post__input" name="post-title" type="text" placeholder="請輸入文章標題" />
          </div>
          <textarea class="edit-post__content" name="post-content" type="text" placeholder="請輸入文章內容" ></textarea>
          <button type="submit" class="btn__edit-post">送出</button>
        </form>
      </main>
    </div>

    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>