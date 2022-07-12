<!DOCTYPE html>

<html>
<body>

<?php 
//Variabelen
$emailerr = $pwerr = "";
$email = $pw = "";
$valid = False;

//Functie test_input

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//Functie check_existing_mail om mail te matchen in users.txt

function check_existing_mail($data) {
	$checkfile = fread(fopen("Users/users.txt", "r"), filesize("Users/users.txt"));
	if(strstr($checkfile, $data) !== False) {
		return True;
	} else {
		return False;
	}
	$checkfile = fclose("Users/users.txt");
}

//Functie check_password om wachtwoord te vergelijken met users.txt

function check_password($data) {
	$file = fopen("Users/users.txt", "r");
	$read = fread($file, filesize("Users/users.txt"));
	$array = explode("|", $read);
	if (in_array($data, $array)) {
		return True;
	} else {
		return False;
	}
	fclose($file);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["email"])) {
		$emailerr = "E-mail is required";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailerr = "Invalid e-mail";
		} else {
			if (check_existing_mail($email) == False){
				$emailerr = "Incorrect e-mail";
			}
		}
	}
	if (empty($_POST["pw"])) {
		$pwerr = "Password is required";
	} else {
		$pw = test_input($_POST["pw"]);
		if (check_password($pw) == False) {
			$pwerr = "Incorrect password";
		}
	}
	if(empty($emailerr) && empty($pwerr)) {
		$valid = True;
	}
}

//showLoginForm
if (!$valid) { ?>
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