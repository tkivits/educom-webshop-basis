<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php
//Variabelen
$namerr = $emailerr = $pwerr = $pwrepeaterr = "";

//showMenu
function showMenu() {?>
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
<?php }

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
	global $namerr, $emailerr, $pwerr, $pwrepeaterr;
	include 'register.php';
}

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
	global $namerr, $emailerr, $pwerr, $pwrepeaterr;
	  if($_SERVER["REQUEST_METHOD"] == "POST") {
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
		  fwrite($user, "\n$email|$name|$pw");
		  fclose($user);
		  return True;
	  }
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
		case 'Register';
		$data = checkRegistration();
		if ($data == True) {
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
	showMenu();
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