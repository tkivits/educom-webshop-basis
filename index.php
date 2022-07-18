<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php

require "functions.php";

$page = getRequestedPage();
$data = processRequest($page);
var_dump($data);
showResponsePage($data); 
?> 

</body>
</html>