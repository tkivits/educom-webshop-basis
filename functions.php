<?php
session_start()
?>

<!DOCTYPE html>

<html>
<body>

<?php
//Variabelen
$salerr = $namerr = $emailerr = $phonerr = $compreferr = $messerr = $pwerr = $pwrepeaterr = "";

//showMenu
function showMenu() {?>
	<ul class="menu">
      <li><a href="?page=Home">Home</a></li>
      <li><a href="?page=About">About</a></li>
      <li><a href="?page=Contact">Contact</a></li>
      <?php if (!isset($_SESSION['login'])) { ?>
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
function showContactPage() {
	global $salerr, $namerr, $emailerr, $phonerr, $compreferr, $messerr;
	include 'contact.php';
}

//showContactThanksPage
function showContactThanksPage() {
	include 'contactthanks.php';
}

//showRegisterPage
function showRegisterPage() {
	global $namerr, $emailerr, $pwerr, $pwrepeaterr;
	include 'register.php';
}

//showLoginPage
function showLoginPage() {
	global $emailerr, $pwerr;
	include 'login.php';
}

//testInput
function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//testContact
function testContact() {
	global $salerr, $namerr, $emailerr, $phonerr, $compreferr, $messerr;
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	  if(empty($_POST["sal"])) {
      $salerr = "Salutation is required";
      } else {
      $sal = testInput($_POST["sal"]);
      }
      if(empty($_POST["name"])) {
        $namerr = "Name is required";
      } else { 
      $name = testInput($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $namerr = "Only letters and spaces are allowed";
        }
      }
      if(empty($_POST["email"])) {
        $emailerr = "E-mail is required";
      } else {
        $email = testInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailerr = "Invalid e-mail";
        }
	  }
      if(empty($_POST["phone"])) {
        $phonerr = "Phone number is required";
      } else {
        $phone = testInput($_POST["phone"]);
	    if (!preg_match("/^0[0-9]{1,3}-{0,1}[0-9]{6,8}$/",$phone)) {
		    $phonerr = "Invalid phone number";
	    }
      }
      if(empty($_POST["compref"])) {
        $compreferr = "Communication preference is required";
      } else {
        $compref = testInput($_POST["compref"]);
      }
      if(empty($_POST["mess"])) {
        $messerr = "A message is required";
      } else {
        $mess = testInput($_POST["mess"]);
      }
      if(empty($salerr) && empty($namerr) && empty($emailerr) && empty($phonerr) && empty($compreferr) && empty($messerr)) {
        return True;
      }
	}
}

//checkUser
function checkUser($data) {
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

//checkRegistration
function checkRegistration() {
	global $namerr, $emailerr, $pwerr, $pwrepeaterr;
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (empty($_POST["name"])) {
		  $namerr = "Name is required";
	  } else {
		  $name = testInput($_POST["name"]);
		  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
          $namerr = "Only letters and spaces are allowed";
		  }
	  }
	  if (empty($_POST["email"])) {
		  $emailerr = "E-mail is required";
	  } else {
		  $email = testInput($_POST["email"]);
		  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $emailerr = "Invalid e-mail";
		  } else {
			  if (checkUser($email) == True) {
				  $emailerr = "E-mail already exists";
			  }
		  }
	  }
	  if (empty($_POST["pw"])) {
		  $pwerr = "Password is required";
	  } else {
		  $pw = testInput($_POST["pw"]);
	  }
	  if (empty($_POST["pwrepeat"])) {
		  $pwrepeaterr = "Please repeat your password";
	  } else {
		  $pwrepeat = testInput($_POST["pwrepeat"]);
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

//processRequest
function processRequest($page) {
	switch($page)
	{
		case 'Contact';
		$data = testContact();
		if ($data == True) {
			$page = 'Thanks';
		}
		break;
		case 'Register';
		$data = checkRegistration();
		if ($data == True) {
			$page = 'Login';
		}
		break;
		case 'Login';
		$data = logInUser();
		if ($data == True) {
			$page = 'Home';
		}
		break;
		case 'Logout';
		logOutUser();
		$page = 'Home';
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
		  showContactPage();
		  break;
		case 'Thanks';
		  showContactThanksPage();
		  break;
		case 'Register';
		  showRegisterPage();
		  break;
		case 'Login';
		  showLoginPage();
		  break;
		default; 
		  include 'home.php';
	}
	Include("footer.php");
}

?>
</body>
</html>