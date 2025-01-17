<?php
  session_start();
  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - New Post';
  $g_page = 'create';
  require 'menu.php'; 
  require 'header.php';     
?>
<div id="all_blogs">
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>New Blog Post</legend>
      <p class="form-group">
        <label for="title">Title</label>
        <input name="title" id="title" class="form-control" />
      </p>
      <p>
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control"></textarea>
      </p>
      <p>
        <input type="submit" class="btn btn-dark" name="command" value="Create" />
      </p>
    </fieldset>
  </form>
</div>
<?php
  require 'footer.php';
?>