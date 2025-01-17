<?php
  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - LOGIN';
  $g_page = 'login';
  require 'menu.php';
  require 'header.php';  
?>
<?php
  if (!isset($g_page)) {
      $g_page = '';
  }
?>

<div id="all_blogs">
    <form name="form1" method="post" action="checklogin.php">
        <fieldset>
            <legend>Member Login</legend>
            <p>
                <label for="title">Username</label>
                <input
                    name="username"
                    class="form-control"
                    type="text"
                    id="username"
                    autocomplete="off"
                    required="required"/>
            </p>
            <p>
                <label for="password">Password</label>
                <input
                    name="password"
                    class="form-control"
                    id="password"
                    type="password"
                    autocomplete="off"
                    required="required"/>
            </p>
            <p>
                <input type="submit" class="btn btn-dark" value="Login"/>
            </p>
        </fieldset>
    </form>
</div>
<?php
  require 'footer.php';
?>