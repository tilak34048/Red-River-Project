<?php
  require 'config.php';
  require 'database.php';
  
  //Html Purifier file
  require 'HTMLPurifier.standalone.php';
  
  //Initialize HTML Purifier
  $purify = HTMLPurifier_Config::createDefault();
  $final_purify = new HTMLPurifier($purify);
  
  function validated_post($title, $content) {
    return ((strlen($title) >= 1) && (strlen($content) >= 1));
  }
  
  if (!$_POST || !isset($_POST['command']) || !isset($_POST['title']) || !isset($_POST['content'])) {
    redirect();
  }
  
  $title = $_POST['title'];
  $content = $_POST['content'];
  
  //Santizing the title and content
  $clean_title= $final_purify->purify($title);
  $clean_content= $final_purify->purify($content);
  
  if (!validated_post($clean_title, $clean_content)) {
    $error_msg = 'Both the title and content must be at least one character.';
  } else if (create_new_post($clean_title, $clean_content)) {
    redirect();
  } else {
    $error_msg = 'Database submission error. [create]';
  }

	$error_msg=isset($error_msg)?$purifier->purify($error_msg):"";

  $g_title = "";
  // We will only reach this portion of the code if something has gone wrong and we haven't redirected.  
  require 'header.php';
?>

<h1>An error occured while processing your post.</h1>
<p>
  <?= $error_msg ?>
</p>
<a href="index.php">Return Home</a>

<?php
  require 'footer.php';
?>
