<?php
  require_once('_conn.php');
  require_once('_utils.php');

  $category_name = $_GET['name'];
  if (empty($_GET['name'])) {
    header('Location: error.php');
    die();
  }
  $sql = 
    'SELECT '.
      'A.id, A.title, A.content, A.created_at, '.
      'C.name '.
    'FROM mily_blog_articles AS A LEFT JOIN mily_blog_categories AS C ON A.category_id = C.id '.
    'WHERE is_deleted = "0" AND name = ? '.
    'ORDER BY A.id DESC';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $category_name);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
  $result = $stmt->get_result(); // 用了 $stmt 後，要再加上這一行才會把結果拿回來
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo escape($category_name); ?> - Mily's blog</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <?php include_once('_header.php') ?>

    <div class="main-min-height">
      <main class="article-list-box main-background">
          <?php if ($result->num_rows === 0) { ?>
            <p class="error-page__title">此分類目前沒有文章</p>
          <?php } else { ?>
            <h1 class="title-main"><span class="material-icons">folder_open</span><?php echo escape($category_name); ?></h1>
            <ul class="article-list">
              <?php while($row = $result->fetch_assoc()) { ?>              
                <li>
                  <a href="article.php?id=<?php echo escape($row['id']) ?>">
                    <p class="article-list__title"><?php echo escape($row['title']); ?></p>
                  </a>
                  <p class="article-list__time">
                    <span class="material-icons">calendar_today</span>
                    <?php echo escape(date('Y.m.d',strtotime($row['created_at']))); ?>
                  </p>
                </li>
              <?php } ?>
            </ul>
          <?php } ?>
      </main>
    </div>

    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>