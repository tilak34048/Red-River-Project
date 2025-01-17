<?php
session_start();
  require 'config.php';
  require 'database.php';
  //Html Purifier file
  require 'HTMLPurifier.standalone.php';
  
  //Initialize HTML Purifier
  $purify = HTMLPurifier_Config::createDefault();
  $final_purify = new HTMLPurifier($purify);
  $g_title = BLOG_NAME . ' - Index';
  $g_page = 'index';
  require 'menu.php';
  require 'header.php';
  
  $posts = find_all_blogs(BLOG_INDEX_NUM_POSTS);

?>
<div id="all_blogs">
  <?php foreach($posts as $post): ?>
    <div class="blog_post">
      <h2><a href="show.php?id=<?=$post['id']?>"><?= $final_purify->purify($post['title']);?></a></h2>
      <p>
        <small>
          <?= $post['created_at'] ?>
        </small>
      </p>
      <div class='blog_content'>
        <?= nl2br($final_purify->purify($post['content'])) ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php
  require 'footer.php';
?>