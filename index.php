<?php
session_start()
?>

<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php
//globale variabelen
$_SESSION['name'] = "";
$_SESSION['page'] = "";

function getRequestedPage(){ //Pagina ophalen
	if(!isset($_GET['page'])){
		return 'Home';
	}
	else {
		return $_GET['page'];
	}
}

function showResponsePage($data){ //Weergave van de pagina
	echo '<h1 class="header">'.$data.'</h1>';
	Include("menu.php");
	switch($data)
	{
		case 'Home';
		  include 'home.php';
		  break;
		case 'About';
		  include 'about.php';
		  break;
		case 'Contact';
		  include 'contact.php';
		  break;
		case 'Register';
		  include 'register.php';
		  break;
		case 'Login';
		  include 'login.php';
		  break;
		default; 
		  include 'home.php';
	}
	Include("footer.php");
}


$_SESSION['page'] = getRequestedPage();
showResponsePage($_SESSION['page']); 
echo $_SESSION['name'];
echo $_SESSION['page'];
echo session_id(); ?> 

</body>
</html>