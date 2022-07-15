<?php
session_start()
?>

<!DOCTYPE html>

<html>
<body>

<ul class="menu">
  <li><a href="?page=Home">Home</a></li>
  <li><a href="?page=About">About</a></li>
  <li><a href="?page=Contact">Contact</a></li>
  <?php if (!$_SESSION['login']) { ?>
  <li><a href="?page=Register">Register</a></li>
  <li><a href="?page=Login">Login</a></li>
  <?php } else { ?>
  <li><a href="?page=Logout">Logout <?php echo $_SESSION['name'] ?></a></li>
  <?php } ?>
</ul>

<div><span class="error">Fields with a * are required</span></div> 
<form class="form" method="post" action="<?php echo htmlspecialchars('?page=Register');?>">
  <div><label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $namerr;?></span></div>
  <div><label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailerr;?></span></div>
  <div><label for="password">Password:</label>
    <input type="password" id="pw" name="pw" value="<?php echo $pw;?>">
    <span class="error">* <?php echo $pwerr;?></span></div>
  <div><label for="password repeat">Repeat password:</label>
    <input type="password" id="pwrepeat" name="pwrepeat" value="<?php echo $pwrepeat;?>">
    <span class="error">* <?php echo $pwrepeaterr;?></span></div>
  <input type="submit" value="Register">
 </form>
<?php //} else {
	//$user = fopen("Users/users.txt", "a");
	//fwrite($user, "\n$email|$name|$pw|");
	//fclose($user);
	//echo '<meta http-equiv="refresh" content="0; URL=?page=Login">';
//} ?>

</body>
</html>