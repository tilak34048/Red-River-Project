<?php
require_once 'PhpRbac/autoload.php';
  if (!isset($g_page)) {
      $g_page = '';
  }
  use PhpRbac\Rbac;
$rbac = new Rbac();
$role_id = $rbac->Roles->returnId('admin');
?>

<ul id="menu" class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <li><a href="index.php" <?= ($g_page == 'index') ? "class='active'" : '' ?>>Home</a></li>
    <li><a href="create.php" <?= ($g_page == 'create') ? "class='active'" : '' ?>>New Post</a></li>
	<?php
	if (isset($_SESSION['username']) && $rbac->Users->hasRole($role_id, $_SESSION['userid'])){
	?>
   <li><a href="admin.php" <?= ($g_page == 'admin') ? "class='active'" : '' ?>>Admin</a></li>

	<?php
	} 
	?>
<?php
	if(isset($_SESSION['username'])){
		?>
	<li><a href="logout.php" <?= ($g_page == 'logout') ? "class='active'" : '' ?>>Logout</a></li>
	<span class="navbar-text">
      Welcome: <?= $_SESSION['username'] ?>
    </span>
	<?php
	}else{
		?>
	<li><a href="register.php" <?= ($g_page == 'register') ? "class='active'" : '' ?>>Register</a></li>
	<li><a href="login.php" <?= ($g_page == 'login') ? "class='active'" : '' ?>>Login</a></li>
	<?php 
	}
	?>
	</ul>
