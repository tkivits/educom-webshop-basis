<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="CSS/stylesheet.css">
</head>
<body>

<?php
//variabelen
$salerr = $namerr = $emailerr = $phonerr = $compreferr = "";
$sal = $name = $email = $phone = $compref = $message = "";

//variabelen verwerken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["salutation"])) {
		$salerr = "Salutation is required";
	} else {
		$sal = test_input($_POST["salutation"]);
	}
	
	if(empty($_POST["name"])) {
		$namerr = "Name is required";
	} else { 
	$name = test_input($_POST["name"]);
	}
	
	if(empty($_POST["email"])) {
		$emailerr = "E-mail is required";
	} else {
		$email = test_input($_POST["email"]);
	}
	
	if(empty($_POST["phone"])) {
		$phonerr = "Phone number is required";
	} else {
		$phone = test_input($_POST["phone"]);
	}
	
	if(empty($_POST["compref"])) {
		$compreferr = "Communication preference is required";
	} else {
		$compref = test_input($_POST["compref"]);
	}
	
	if(empty($_POST["message"])) {
		$message = "";
	} else {
		$message = test_input($_POST["message"]);
	}
}

//functie test_input
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<h1>Contact</h1>

<ul class="menu">
	<li><a href="http://localhost/educom-webshop-basis/">Home</a></li>
	<li><a href="http://localhost/educom-webshop-basis/about.html">About</a></li>
	<li><a href="http://localhost/educom-webshop-basis/contact.html">Contact</a></li>
</ul>

<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="salutation"></label>
		<select id="salutation" name="salutation">
			<option value="">Choose</option>
			<option value="mr" <?php if (isset($sal) && $sal=="mr") echo "selected";?>>Mr.</option>
			<option value="mrs"<?php if (isset($sal) && $sal=="mrs") echo "selected";?>>Mrs</option>
		</select>
		<span> <?php echo $salerr ?></span><br>
	<label for="name">Name:</label>
		<input type="text" id="name" name="name" value="<?php echo $name;?>">
		<span> <?php echo $namerr;?></span><br>
	<label for="email">E-mail:</label>
		<input type="email" id="email" name="email" value="<?php echo $email;?>">
		<span> <?php echo $emailerr;?></span><br>
	<label for="phone">Phone number:</label>
		<input type="tel" id="phone" name="phone" value="<?php echo $phone;?>">
		<span> <?php echo $phonerr;?></span><br>
	<label for="compref">What is your communication preference?</label>
	<input type="radio" id="email" name="compref" <?php if (isset($compref) && $compref=="email") echo "checked";?> value="email">
		<label for="email">E-mail</label>
	<input type="radio" id="telephone" name="compref" <?php if (isset($compref) && $compref=="telephone") echo "checked";?> value="telephone">
		<label for="telephone">Telephone</label>
		<span> <?php echo $compreferr;?></span><br>
	<textarea id="message" name="message" rows="8" cols="50">Tell us why you want to contact us!</textarea><br>
	<input type="submit" value="Submit">
</form>

<footer class="foot">
	<p>&copy; 2022 Teun Kivits</p>
</footer>


</body>
</html>