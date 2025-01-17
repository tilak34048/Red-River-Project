<?php
  require 'config.php';
  require 'database.php';
  $g_title = BLOG_NAME . ' - LOGIN';
  $g_page = 'login';
  require 'menu.php'; 
  require 'header.php';  
  ?>

<div id="all_blogs">
<?php
  ob_start(); // session management
  require('databaseconnection.php');
  
//Implementing brute force mitigation
$total_failed_login = 3;
$lockout_time = 15;
$account_locked = false;
date_default_timezone_set('America/Winnipeg');
//End of mitigation

$user=$_POST['username'];

	// Check the database (Check user information)
$data = $db->prepare( 'SELECT failed_login, last_login FROM members WHERE username = (:username) LIMIT 1;' );
	$data->bindParam( ':username', $user, PDO::PARAM_STR );
	$data->execute();
	$row = $data->fetch();

	// Check to see if the user has been locked out.
	if( ( $data->rowCount() == 1 ) && ( $row[ 'failed_login' ] >= $total_failed_login ) )  {
		// User locked out. Following line should not  be included when in production, comment out for competency
		//echo "<pre><br />This account has been locked due to too many incorrect logins.</pre>";

		// Calculate when the user would be allowed to login again
		$last_login = strtotime( $row[ 'last_login' ] );
		$timeout    = $last_login + ($lockout_time * 60);
		$timenow    = time();

		// Shows the login attempt timings.  The three lines below should not be 
		// included when in production, comment out for competency
		//print "The last login was: " . date ("h:i:s", $last_login) . "<br />";
		//print "The timenow is: " . date ("h:i:s", $timenow) . "<br />";
		//print "The account is locked for till time: " . date ("h:i:s", $timeout) . "<br />";

		// Check to see if enough time has passed, if it hasn't locked the account
		if( $timenow < $timeout ) {
			$account_locked = true;
			//print "The account is locked for time<br />";
		}
	}

$mypassword=$_POST['password'];
$select_sql = "SELECT id, password FROM members WHERE username=:username;";
$statement = $db->prepare($select_sql);
$statement->bindParam(':username',$_POST['username']);
$statement->execute();
$pass = $statement->fetch();
$returnedpassword=$pass['password'];
$checkpassword = password_verify($mypassword, $returnedpassword);
// If returned password matches entered password, valid login
if($checkpassword && $_POST['password']<>'' && $account_locked == false){
	// Register $myusername and redirect to file "login_success.php"
	session_start();
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['userid'] = $pass['id']; // add user ID to session info
// the following will be used for brute force attacks in the future
echo "Successful login as: ".$_SESSION['username'];
header("refresh:1; url=index.php");
		// Reset bad login count
		$data = $db->prepare( 'UPDATE members SET failed_login = "0" WHERE username = (:username) LIMIT 1;' );
		$data->bindParam( ':username', $user, PDO::PARAM_STR );
		$data->execute();
	}else{
		if ($account_locked){
			echo "This account has been locked due to too many incorrect logins.";
		}else{
			echo("Wrong Username or Password.");
			echo nl2br("\n");
			echo nl2br("\n");
			echo nl2br("\n");
			echo "Redirecting... to LoginPage";
			header("refresh:2; url=login.php");
		}
		// Update bad login count
		$data = $db->prepare( 'UPDATE members SET failed_login = (failed_login + 1) WHERE username = (:username) LIMIT 1;' );
		$data->bindParam( ':username', $user, PDO::PARAM_STR );
		$data->execute();

		// Set the last login time.  This pauses the wait time to the $lockout_time for each attempt.
	$data = $db->prepare( 'UPDATE members SET last_login = now() WHERE username = (:username) LIMIT 1;' );
	$data->bindParam( ':username', $user, PDO::PARAM_STR );
	$data->execute();
	}
ob_end_flush();
?>
</div>