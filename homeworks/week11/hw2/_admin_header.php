<header class="header">
  <nav class="navbar">
    <a class="navbar__logo" href='admin.php'>管理後台</a>
    <ul class="navbar__list">
      <li><a href="admin_article_management.php">文章管理</a></li>
      <li><a href="admin_category.php">分類管理</a></li>
      <?php if ($_SESSION['username']) { ?>
        <li><a class="btn__admin" href="handle_logout.php">登出</a></li>
      <?php } ?>
    </ul>
  </nav>
</header>