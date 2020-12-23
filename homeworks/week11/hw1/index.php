<?php
  session_start();
  require_once('_conn.php');
  require_once('_utils.php');

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) { // 判斷如果 $token 不是空的，就是登入狀態
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  $page = 1;
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 5;
  $offset = ($page - 1) * $items_per_page;

  // $stmt = $conn->prepare('SELECT * FROM mily_comments LEFT JOIN mily_users ON mily_comments.username = mily_users.username ORDER BY mily_comments.id DESC');
  // 我們真正要的是 mily_comments 的 id，但如果像上述一樣，沒有用 AS 個別命名的話，得到的 id 卻是 mily_users 資料表的 id （會覆蓋過去）
  $sql = 
    'SELECT '.
      'C.id AS id, C.content AS content, '.
      'C.created_at AS created_at, U.nickname AS nickname, U.username as username '.
    'FROM mily_comments AS C '.
    'LEFT JOIN mily_users AS U ON C.username = U.username '.
    'WHERE C.is_deleted = "0" '.
    'ORDER BY C.id DESC '.
    'LIMIT ? OFFSET ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $items_per_page, $offset);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error); // 如果沒有東西就顯示錯誤訊息
  }
  $result = $stmt->get_result(); // 用了 $stmt 後，要再加上這一行才會把結果拿回來
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>今天吃什麼 ლ(´ڡ`ლ)</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <nav class="nav nav__menu-active">
    <div class="nav__content">
      <a class="logo" href="index.php">今天吃什麼<span>ლ(´ڡ`ლ)</span></a>
      <div class="nav__list">
      <?php if (!$username) { ?>
        <a class="nav__item" href="register.php"><img class="nav__item-icon" src="images/signup.svg">註冊</a>
        <a class="nav__item" href="login.php"><img class="nav__item-icon" src="images/signin.svg">登入</a>        
      <?php } else { ?>
        <p class="nav__nickname">Hi，<?php echo escape($user['nickname']);?></p>
        <?php if ($user && $user['role'] === 'ADMIN') { ?>
          <a class="nav__item" href="admin.php"><img class="nav__item-icon" src="images/admin.svg">管理後台</a>
        <?php } ?>
        <a class="nav__item" href="update_user.php"><img class="nav__item-icon" src="images/user-edit.svg">修改資料</a>
        <a class="nav__item" href="logout.php"><img class="nav__item-icon" src="images/signin.svg">登出</a>
      <?php } ?>
      </div>
      <div class="nav__menu-btn"></div>
    </div>
  </nav>
  <div class="container">
    <?php if ($username && !hasPermission($user, 'create', NULL)) { ?>
      <div class="board board-blocklist">
        <p>抱歉，您已被停權</p>
      </div>
    <?php } else if ($username) { ?>
      <form class="board" method="POST" action="handle_add_comment.php">
        <?php
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = '資料不齊全';
            }
            echo '<h2 class="error">錯誤：' . $msg . '</h2>';
          }
        ?>
        <textarea class="board__input-tittle" name="content" rows="5" placeholder="<?php echo escape($user['nickname']);?>，一起聊聊要吃什麼吧！"></textarea>
        <button class="board__submit" type="submit">送出<img src="images/send.svg"></button>
      </form>        
    <?php } else { ?>
      <div class="board board-guest">
        <p>立即登入發布留言</p>
        <a class="board-guest__btn" href="login.php">登入</a>
      </div>
    <?php } ?>
    <section class="comment">
        <?php while($row = $result->fetch_assoc()) { ?>
          <div class="card">
            <div class="card__info">
              <div class="card__avatar"></div>
              <div class="card__detail">
                  <p class="card__author"><?php echo escape($row['nickname']); ?></p>
                  <p class="card__time"><?php echo escape($row['created_at']); ?></p>
              </div>
              <?php if (hasPermission($user, 'update', $row)) { ?>
                <div class="card__manage-action modal modal-hide">
                  <a class="manage-btn" href="update_comment.php?id=<?php echo $row['id']; ?>"><img src="images/comment-edit.svg" alt="編輯"></a>
                  <img class="manage-btn delete-modal__btn" src="images/comment-delete.svg" alt="刪除">
                  <!-- 確認刪除視窗 -->
                  <div class="modal-box">
                    <div class="modal__content">
                      <span class="modal__close">&times;</span>
                      <img src="images/comment-delete.svg" alt="刪除">
                      <h3>確定要刪除留言嗎？</h3>
                      <p>刪除後將無法回復內容</p>
                      <div class="modal__action">
                        <p class="btn modal__cancel">取消</p>
                        <a class="btn" href="handle_delete_comment.php?id=<?php echo $row['id']; ?>">刪除</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
            <p class="card__message"><?php echo escape($row['content']); ?></p>
          </div>
        <?php } ?>
    </section>
    <?php 
      $stmt = $conn->prepare('SELECT count(id) AS count FROM mily_comments WHERE is_deleted = "0"');
      // 找出沒被刪除的留言
      $result = $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $count = $row['count'];
      $total_page = ceil($count / $items_per_page);
    ?>
    <div class="page">
        <div class="page___info">
        <p>總共 <?php echo $count; ?> 筆留言</p>
        <p><?php echo $page; ?> / <?php echo $total_page; ?> 頁</p>
        </div>

        <!------------ 頁碼  ------------>

        <!----- 第一頁且後面還有頁數 ----->
        <div class="paginator">
          <?php if ($page == 1 && $page != $total_page) { ?>            
            <p class="paginator__first"></p><!-- 最前頁 -->
            <p class="paginator__previous"></p><!-- 上一頁 -->
            <p>1</p><!-- 第一頁 -->
            <a class="paginator__next" href="index.php?page=<?php echo $page + 1; ?>"></a><!-- 下一頁 -->
            <a class="paginator__last" href="index.php?page=<?php echo $total_page; ?>"></a><!-- 最後頁 -->
          <?php } ?>

        <!----- 第一頁但後面沒有頁數了 ----->
          <?php if ($page == 1 && $page == $total_page) { ?>            
            <p class="paginator__first"></p><!-- 最前頁 -->
            <p class="paginator__previous"></p><!-- 上一頁 -->
            <p>1</p><!-- 第一頁 -->
            <p class="paginator__next"></p><!-- 下一頁 -->
            <p class="paginator__last"></p><!-- 最後頁 -->
          <?php } ?>
        
          <!----- 中間頁 ----->
          <?php if ($page != 1 && $page != $total_page) { ?>
            <a class="paginator__first" href="index.php"></a><!-- 最前頁 -->
            <a class="paginator__previous" href="index.php?page=<?php echo $page - 1; ?>"></a><!-- 上一頁 -->
            <p><?php echo $page; ?></p><!-- 當前頁數 -->
            <a class="paginator__next" href="index.php?page=<?php echo $page + 1; ?>"></a><!-- 下一頁 -->
            <a class="paginator__last" href="index.php?page=<?php echo $total_page; ?>"></a><!-- 最後頁 -->
          <?php } ?>

          <!----- 最末頁 ----->
          <?php if ($page != 1 && $page == $total_page) { ?>
            <a class="paginator__first" href="index.php"></a><!-- 最前頁 -->
            <a class="paginator__previous" href="index.php?page=<?php echo $page - 1; ?>"></a><!-- 上一頁 -->
            <p><?php echo $page; ?></p><!-- 當前頁數 -->
            <p class="paginator__next"></p><!-- 下一頁 -->
            <p class="paginator__last"></p><!-- 最後頁 -->
          <?php } ?>        
        </div>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>