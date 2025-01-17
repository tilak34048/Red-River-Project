<?php
ob_start(); // session management
require('databaseconnection.php');
$tbl_name="members"; // Table name if you wish to use a variable
$myusername=$_POST['username'];
$mypassword=$_POST['password'];
$encrypted_password = password_hash($mypassword, PASSWORD_DEFAULT);
$insert_sql="insert into members (username,password) values(:myusername,:encrypted_password)";
$statement = $db->prepare($insert_sql);
$statement->bindParam(':myusername',$myusername);
$statement->bindParam(':encrypted_password',$encrypted_password);
$statement->execute() or die(print_r($statement->errorInfo(), true));
$pass = $statement->fetch();
  require 'config.php';
  $g_title = BLOG_NAME . '';
  require 'header.php';
?>
<div id="all_blogs">
<?php
echo "Registered";
header("refresh:3; url=login.php");
// Again, we should never see this in a production environment
//printf("<br />SQL statement is $insert_sql");
ob_end_flush();
?>
</div>
<?php
  require 'footer.php';
?>


<!-- Process.php -->
<?php
  session_start();
  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - REGISTER';
  $g_page = 'register';
  require 'header.php';
  require 'menu.php';
?>
<?php
  if (!isset($g_page)) {
      $g_page = '';
  }
?>



<div id="all_blogs">
  <form name="form1" method="post" action="process_register.php">
    <fieldset>
      <legend>Member Register</legend>
      <p>
        <label for="title">Username</label>
        <input name="username" type="text" id="username" autocomplete="off" required />
      </p>
      <p>
        <label for="title">Email</label>
        <input name="email" type="text" id="email" autocomplete="off" required style="width: 40em";/>
      </p>
      <p>
        <label for="password">Password</label>
        <input name="password" id="password" type="password" autocomplete="off" required />
      </p>
      <p>
        <label for="Verify_Password">Verify_Password</label>
        <input name="password2" id="password2" type="password" autocomplete="off" required style="width: 40em";/>
      </p>
      <p>
        <input type="submit" name="submit" value="Register" />
      </p>
    </fieldset>
  </form>
</div>

<?php
  require 'footer.php';
?>





<!-- table width="300" border="0" align="center" cellpadding="0"
cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="process_register.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1"
bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>Member Register </strong></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="6">:</td>
<td width="294"><input name="username" type="text" id="username"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="password" type="text" id="password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Register"></td>
</tr>
</table>
</td>
</form>
</tr>
</table> -->