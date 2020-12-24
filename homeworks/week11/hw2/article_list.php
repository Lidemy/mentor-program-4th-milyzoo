<?php
  require_once('_conn.php');
  require_once('_utils.php');

  $page = 1;
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 5;
  $offset = ($page - 1) * $items_per_page;

  $stmt = $conn->prepare('SELECT * FROM mily_blog_articles WHERE is_deleted = "0" ORDER BY id DESC LIMIT ? OFFSET ?');
  $stmt->bind_param('ii', $items_per_page, $offset);
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
  <title>全文列表 - Mily's blog</title>
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
        <ul class="article-list">
          <?php if ($result->num_rows == 0) { ?>
            <li class="admin-article__empty-item">目前沒有文章</li>
          <?php } ?>
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
        <!-- 頁碼  -->
        <div class="paginator">
          <?php 
            $stmt = $conn->prepare('SELECT count(id) AS count FROM mily_blog_articles WHERE is_deleted = "0"');
            // 找出沒被刪除的文章
            $result = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $total_page = ceil($count / $items_per_page);
          ?>
          <?php if ($page === 1) { ?>
            <!-- 最前頁 -->
            <p><span class="material-icons">first_page</span></p>
            <!-- 上一頁 -->
            <p><span class="material-icons">chevron_left</span></p>
            <!-- 當前頁數 -->
            <a href="article_list.php">1</a>
            <!-- 下一頁 -->
            <a href="article_list.php?page=<?php echo $page + 1; ?>"><span class="material-icons">chevron_right</span></a>
            <!-- 最後頁 -->
            <a href="article_list.php?page=<?php echo $total_page; ?>"><span class="material-icons">last_page</span></a>
          <?php } ?>

          <?php if ($page !== 1 && $page != $total_page) { ?>
            <!-- 最前頁 -->
            <a href="article_list.php"><span class="material-icons">first_page</span></a>
            <!-- 上一頁 -->
            <a href="article_list.php?page=<?php echo $page - 1; ?>"><span class="material-icons">chevron_left</span></a>
            <!-- 當前頁數 -->
            <a href="article_list.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <!-- 下一頁 -->
            <a href="article_list.php?page=<?php echo $page + 1; ?>"><span class="material-icons">chevron_right</span></a>
            <!-- 最後頁 -->
            <a href="article_list.php?page=<?php echo $total_page; ?>"><span class="material-icons">last_page</span></a>
          <?php } ?>

          <?php if ($page == $total_page) { ?>
            <!-- 最前頁 -->
            <a href="article_list.php"><span class="material-icons">first_page</span></a>
            <!-- 上一頁 -->
            <a href="article_list.php?page=<?php echo $page - 1; ?>"><span class="material-icons">chevron_left</span></a>
            <!-- 當前頁數 -->
            <a href="article_list.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <!-- 下一頁 -->
            <p><span class="material-icons">chevron_right</span></p>
            <!-- 最後頁 -->
            <p><span class="material-icons">last_page</span></p>
          <?php } ?>
        </div>
      </main>
    </div>
    
    <?php include_once('_footer.php') ?>
  </div>
</body>
</html>