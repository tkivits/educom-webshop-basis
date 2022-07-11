<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php
function getRequestedPage(){
	if(!isset($_GET['page'])){
		return 'Home';
	}
	else {
		return $_GET['page'];
	}
}

function showResponsePage($page){
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
		case 'Contact'; // Nog niet de juiste reactie bij submit!
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