<!DOCTYPE html>
<html>
<body>

<?php 
//Variabelen
$emailerr = $pwerr = "";
$email = $pw = $pw_check = "";
$login = False;

//Functie test_input

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//Functie check_user om gebruikersdata te vergelijken met users.txt

function check_user($data) {
	$file = fopen("Users/users.txt", "r");
	$read = fread($file, filesize("Users/users.txt"));
	$read = preg_replace('~[\r\n]+~', '|', $read);
	$array = explode("|", $read);
	if (in_array($data, $array)) {
		return True;
	} else {
		return False;
	}
	fclose($file);
}

//Functie match_password om wachtwoord te vergelijken met users.txt

function check_password($data) {
	$file = fopen("Users/users.txt", "r");
	$read = fread($file, filesize("Users/users.txt"));
	$read = preg_replace('~[\r\n]+~', '|', $read);
	$array = explode("|", $read);
	$pw_check = $array[array_search($data, $array)+2];
	fclose ($file);
	return $pw_check;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["email"])) {
		$emailerr = "E-mail is required";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailerr = "Invalid e-mail";
		} else {
			if (check_user($email) == False){
				$emailerr = "Unknown e-mail";
			} else {
				$pw_check = check_password($email);
			}
		}
	}
	if (empty($_POST["pw"])) {
		$pwerr = "Password is required";
	} else {
		$pw = test_input($_POST["pw"]);
	}
	if ($pw !== $pw_check) {
		$pwerr = "E-mail doesn't match password";
	}
	if(empty($emailerr) && empty($pwerr)) {
		$login = True;
	}
}

//showLoginForm
if (!$login) { ?>
<form class="form" method="post" action="<?php echo htmlspecialchars('?page=Login');?>">
  <div><label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailerr;?></span></div>
  <div><label for="password">Password:</label>
    <input type="password" id="pw" name="pw" value="<?php echo $pw;?>">
    <span class="error">* <?php echo $pwerr;?></span></div>
<input type="submit" value="Login">
<?php } ?>

</body>
</html>