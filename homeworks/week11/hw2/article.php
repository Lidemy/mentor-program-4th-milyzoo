<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');
  
  $id = intval($_GET['id']);
  if (empty($id)) { // 如果 $id 是空的
    header('Location: error.php'); // 就導到錯誤頁面
    die();
  }

  $sql = 
    'SELECT '.
      'A.id, A.title, A.content, A.created_at, '.
      'C.name '.
    'FROM mily_blog_articles AS A LEFT JOIN mily_blog_categories AS C ON A.category_id = C.id '.
    'WHERE A.id = ?';

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
  <title><?php echo $row['title']; ?> - Mily's blog</title>
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
          <article class="article__item">
            <h1 class="article__title"><?php echo escape($row['title']); ?></h1>
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
            <div class="article__content"><?php echo escape($row['content']); ?></div>
          </article>
        </section>
      </main>
    </div>

    <?php include_once('_footer.php') ?>
  </div>
</body>

</html>