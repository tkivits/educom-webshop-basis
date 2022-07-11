<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php
function getRequestedPage(){ //Pagina ophalen
	if(!isset($_GET['page'])){
		return 'Home';
	}
	else {
		return $_GET['page'];
	}
}

function showResponsePage($page){ //Weergave van de pagina
	echo '<h1 class="header">'.$page.'</h1>';
	Include("menu.php");
	switch($page)
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
		default; 
		  include 'home.php';
	}
	Include("footer.php");
}


$page = getRequestedPage();
showResponsePage($page); ?> 

</body>
</html>