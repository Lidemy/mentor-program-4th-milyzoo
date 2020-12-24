<?php
  require_once('_conn.php');
  require_once('_utils.php');

  $sql = 'SELECT * FROM mily_blog_categories';
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
  <title>文章分類 - Mily's blog</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <?php include_once('_header.php') ?>

    <div class="main-min-height">
      <main class="category-box main-background">
        <h1 class="title-main"><span class="material-icons">folder_open</span>文章分類</h1>
        <ul class="category-list">
          <?php if ($result->num_rows == 0) { ?>
            <li class="admin-article__empty-item">目前沒有分類</li>
          <?php } ?>
          <?php while($row = $result->fetch_assoc()) { ?>
            <li>
              <a href="categories.php?name=<?php echo escape($row['name']) ?>"><?php echo escape($row['name']); ?></a>
            </li>
          <?php } ?>
        </ul>
      </main>
    </div>
    
    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>