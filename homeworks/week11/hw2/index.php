<?php
  require_once('_conn.php');
  require_once('_utils.php');
  session_start();

  $items_per_page = 5;
  $sql = 
  'SELECT '.
    'A.id, A.title, A.content, A.created_at, '.
    'C.name '.
  'FROM mily_blog_articles AS A LEFT JOIN mily_blog_categories AS C ON A.category_id = C.id '.
  'WHERE is_deleted = "0" '.
  'ORDER BY A.id DESC '.
  'LIMIT ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $items_per_page);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
  $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mily's blog</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/main.css" />
</head>

<body>
  <div class="container">
    <?php include_once('_header.php') ?>

    <div class="main-min-height">
      <main class="main-background">
        <section class="article">
          <?php if ($result->num_rows === 0) { ?>
            <article class="admin-article__empty-item">目前沒有文章</article>
          <?php } ?>
          <?php while($row = $result->fetch_assoc()) { ?>
            <article class="article__item">
              <h2 class="article__title"><a href="article.php?id=<?php echo escape($row['id']) ?>"><?php echo escape($row['title']); ?></a></h2>
              <div class="article__info">
                <div class="article__time">
                  <span class="material-icons icon-s">calendar_today</span>
                  <?php echo escape(date('Y.M.d',strtotime($row['created_at']))); ?>
                </div>
                <div class="article__category">            
                  <a href="categories.php?name=<?php echo escape($row['name']) ?>">
                    <span class="material-icons icon-m">folder_open</span>
                    <?php echo escape($row['name']); ?>
                  </a>
                </div>
              </div>
              <div class="article__content"><?php echo escape(limitTheWords($row['content'], 125)); ?></div>
              <a class="btn-read-more" href="article.php?id=<?php echo escape($row['id']) ?>">READ MORE</a>
            </article>
          <?php } ?>
        </section>
      </main>
    </div>
  </div>
  
  <?php include_once('_footer.php') ?>
</body>
</html>