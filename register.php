<?php
session_start()
?>

<!DOCTYPE html>

<html>
<body>

<div><span class="error">Fields with a * are required</span></div> 
<form class="form" method="post" action="<?php echo htmlspecialchars('?page=Register');?>">
  <div><label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php if (isset($_POST['name'])) {
		echo $_POST['name'];
	} else {
		echo "";
	};?>">
    <span class="error">* <?php echo $namerr; ?></span></div>
  <div><label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php if (isset($_POST['email'])) {
		echo $_POST['email'];
	} else {
		echo "";
	};?>">
    <span class="error">* <?php echo $emailerr; ?></span></div>
  <div><label for="password">Password:</label>
    <input type="password" id="pw" name="pw" value="<?php if (isset($_POST['pw'])) {
		echo $_POST['pw'];
	} else {
		echo "";
	};?>">
    <span class="error">* <?php echo $pwerr; ?></span></div>
  <div><label for="password repeat">Repeat password:</label>
    <input type="password" id="pwrepeat" name="pwrepeat" value="<?php if(isset($_POST['pwrepeat'])) {
		echo $_POST['pwrepeat'];
	} else {
		echo "";
	};?>">
    <span class="error">* <?php echo $pwrepeaterr; ?></span></div>
  <input type="submit" value="Register">
 </form>

</body>
</html>