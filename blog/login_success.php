<?php

  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - LOGIN SUCCESSFUL';
  $g_page = 'logout';
  require 'header.php';
$posts = find_all_blogs(BLOG_INDEX_NUM_POSTS);
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
session_start();
if(!isset($_SESSION['username'])){
header("location:login.php");
}
?>
Welcome <?= $_SESSION['username'] ?>

<?php require 'menu.php';?>

<!-- ALL BlOG POST CODE-->
<div id="all_blogs">
  <?php foreach($posts as $post): ?>
    <div class="blog_post">
      <h2><a href="show.php?id=<?=$post['id']?>"><?= htmlspecialchars($post['title']) ?></a></h2>
      <p>
        <small>
          <?= $post['created_at'] ?>
        </small>
      </p>
      <div class='blog_content'>
        <?= nl2br(htmlspecialchars($post['content'])) ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php
  require 'footer.php';
?>
