<?php
  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - Register';
  $g_page = 'register';
  require 'menu.php';
  require 'header.php';  
  // set an error array so you can 
  // print out all problems
  $errors = array(); 
  $myusername='';
  $myemail='';
 
?>
<div id="all_blogs">
<?php 
if (isset($_POST['password']))
{
ob_start(); // session management
 
$myusername = $_POST['username'];
$myemail = $_POST['email'];
$mypassword = $_POST['password'];
$mypassword2 = $_POST['password2'];
 
 
  if (empty($myusername)) { array_push($errors, "Username required!"); }
  if (empty($myemail)) { array_push($errors, "Email is required!"); }
  if (empty($mypassword)) { array_push($errors, "Password required!"); }
  if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) { array_push($errors, "E-mail is not valid!"); }
  if ($mypassword != $mypassword2) { array_push($errors, "The two passwords do not match!"); }
 
 
require('databaseconnection.php');
$tbl_name="members"; // Table name if you wish to use a variable
 
// Verify username and email don't exist in members table
  $user_check_query = "SELECT username, email FROM members WHERE username=:myusername OR email=:myemail LIMIT 1";
	$statement = $db->prepare($user_check_query);
	$statement->bindParam(':myusername',$myusername);
	$statement->bindParam(':myemail',$myemail);
	$statement->execute() or die(print_r($statement->errorInfo(), true));
	$user = $statement->fetch();
 
if ($user) { // if user exists, which field?
    if ($user['username'] == $myusername) {
      array_push($errors, "Username already exists!");
    }
 
    if ($user['email'] == $myemail) {
      array_push($errors, "Email already exists!");
    }
  }
 
 
if (count($errors) == 0) {
 
$encrypted_password = password_hash($mypassword, PASSWORD_DEFAULT);
$insert_sql="insert into members (username,password,email) values
(:myusername,:encrypted_password, :myemail)";
$statement = $db->prepare($insert_sql);
$statement->bindParam(':myusername',$myusername);
$statement->bindParam(':myemail',$myemail);
$statement->bindParam(':encrypted_password',$encrypted_password);
$statement->execute() or die(print_r($statement->errorInfo(), true));
$pass = $statement->fetch();
 
  
  $posts = find_all_blogs(BLOG_INDEX_NUM_POSTS);
echo "Registered";
echo nl2br("\n");
echo nl2br("\n");
echo nl2br("\n");
echo "Redirecting... to Login Page";
header("refresh:2; url=login.php");
}
	else
	{
		foreach ($errors as $error) {
			echo "<p>$error</p>";
		}
}
 
// Again, we should never see this in a production environment
//printf("<br />SQL statement is $insert_sql");
ob_end_flush();
}
if (!isset($_POST['password']) || count($errors) > 0)
 
{
?>
 
 <form name="form1" method="post" action="register.php">
    <fieldset>
      <legend>Member Register</legend>
      <p>
        <label for="title">Username</label>
        <input name="username" class="form-control" type="text" id="username" autocomplete="off" value="<?=$myusername?>"  required/>
      </p>
      <p>
        <label for="title">Email</label>
        <input name="email" class="form-control" type="text" id="email" autocomplete="off" value="<?=$myemail?>" style="width: 40em"; required/>
      </p>
      <p>
        <label for="password">Password</label>
        <input name="password" class="form-control" id="password" type="password" autocomplete="off" required/>
      </p>
      <p>
        <label for="Verify_Password">Verify_Password</label>
        <input name="password2" class="form-control" id="password2" type="password" autocomplete="off"  style="width: 40em"; required/>
      </p>
      <p>
        <input type="submit" class="btn btn-dark" name="submit" value="Register" />
      </p>
    </fieldset>
  </form>
<?php
}
?>
</div>
<?php
  require 'footer.php';
?>	