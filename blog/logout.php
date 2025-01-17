<?php
// Put this code in first line of web page.
session_start();
session_destroy();
  require 'config.php';
  $g_title = BLOG_NAME . '';
  require 'header.php';
  ?>
    <div id="all_blogs">
	<?php
echo "Logout Session Username is ".$_SESSION['username'];
session_unset();
echo nl2br("\n");
echo nl2br("\n");
echo nl2br("\n");
echo "Redirecting... to HomePage";
header("refresh:4; url=index.php");
?>
</div>