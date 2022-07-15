<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php
//Variabelen

//showHomePage
function showHomePage() {
	include 'home.php';
}

//showAboutpage
function showAboutPage() {
	include 'about.php';
}

//showContactPage


//showRegisterPage
function showRegisterPage() {
$namerr = $emailerr = $pwerr = $pwrepeaterr = "";
$name = $email = $pwerr = $pwrepeat = "";
?>
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
<?php }

//testInput
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//testContact
function testContact() {
	if(empty($_POST["salutation"])) {
    $salerr = "Salutation is required";
  } else {
    $sal = test_input($_POST["salutation"]);
  }
  
  if(empty($_POST["name"])) {
    $namerr = "Name is required";
  } else { 
  $name = test_input($_POST["name"]);
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
    $namerr = "Only letters and spaces are allowed";
    }
  }
  
  if(empty($_POST["email"])) {
    $emailerr = "E-mail is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailerr = "Invalid e-mail";
    }
  }
  
  if(empty($_POST["phone"])) {
    $phonerr = "Phone number is required";
  } else {
    $phone = test_input($_POST["phone"]);
	if (!preg_match("/^0[0-9]{1,3}-{0,1}[0-9]{6,8}$/",$phone)) {
		$phonerr = "Invalid phone number";
	}
  }
  
  if(empty($_POST["compref"])) {
    $compreferr = "Communication preference is required";
  } else {
    $compref = test_input($_POST["compref"]);
  }
  
  if(empty($_POST["mess"])) {
    $messerr = "A message is required";
  } else {
    $mess = test_input($_POST["mess"]);
  }
  if(empty($salerr) && empty($namerr) && empty($emailerr) && empty($phonerr) && empty($compreferr) && empty($messagerr)) {
    $valid = True;
  }
}

//checkExistingMail
function checkExistingMail($data) {
	$checkfile = fread(fopen("Users/users.txt", "r"), filesize("Users/users.txt"));
	if(strstr($checkfile, $data) !== False) {
		return True;
	} else {
		return False;
	}
	$checkfile = fclose("Users/users.txt");
}

//checkRegistration
function checkRegistration() {
	if (empty($_POST["name"])) {
		$namerr = "Name is required";
	} else {
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $namerr = "Only letters and spaces are allowed";
		}
	}
	if (empty($_POST["email"])) {
		$emailerr = "E-mail is required";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailerr = "Invalid e-mail";
		} else {
			if (checkExistingMail($email) == True) {
				$emailerr = "E-mail already exists";
			}
		}
	}
	if (empty($_POST["pw"])) {
		$pwerr = "Password is required";
	} else {
		$pw = test_input($_POST["pw"]);
	}
	if (empty($_POST["pwrepeat"])) {
		$pwrepeaterr = "Please repeat your password";
	} else {
		$pwrepeat = test_input($_POST["pwrepeat"]);
		if ($pw !== $pwrepeat) {
			$pwrepeaterr = "Entered passwords do not match";
		}
	}
	if (empty($namerr) && empty($emailerr) && empty($pwerr) && empty($pwrepeaterr)) {
		$user = fopen("Users/users.txt", "a");
		fwrite($user, "\n$email|$name|$pw|");
		fclose($user);
		return 'valid';
	}
}

//getRequestedPage
function getRequestedPage(){
	if(!isset($_GET['page'])){
		return 'Home';
	}
	else {
		return $_GET['page'];
	}
}

//processRequest
function processRequest($page) {
	switch($page)
	{
		case 'contact';
		$data = testContact();
		if (isset($data)) {
			$page = 'Thanks';
		}
		break;
		case 'register';
		$data = checkRegistration();
		if ($data['valid']) {
			$page = 'Login';
		}
		break;
		}
	$data = $page;
	return $data;
}

//showResponsePage
function showResponsePage($data){
	echo '<h1 class="header">'.$data.'</h1>';
	switch($data)
	{
		case 'Home';
		  showHomePage();
		  break;
		case 'About';
		  showAboutPage();
		  break;
		case 'Contact';
		  showContactForm();
		  break;
		case 'Thanks';
		  showContactThanks();
		  break;
		case 'Register';
		  showRegisterPage();
		  break;
		case 'Login';
		  include 'login.php';
		  break;
		 case 'Logout';
		  include 'logout.php';
		  break;
		default; 
		  include 'home.php';
	}
	Include("footer.php");
}

?>
</body>
</html>