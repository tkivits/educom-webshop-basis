<!DOCTYPE html>
<html>
<body>

<div><span class="error">Fields with a * are required!</span></div>
<form class="form" method="post" action="<?php echo htmlspecialchars('?page=Contact');?>">
  <div><label for="salutation"></label>
    <select id="sal" name="sal">
      <option value="">Choose</option>
      <option value="Mr." <?php if (isset($_POST['sal']) && $_POST['sal'] == "Mr.") echo "selected";?>>Mr.</option>
      <option value="Mrs"<?php if (isset($_POST['sal']) && $_POST['sal'] == "Mrs") echo "selected";?>>Mrs</option>
    </select>
    <span class="error">* <?php echo $salerr ?></span></div>
  <div><label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php if (isset($_POST['name'])) {
		echo $_POST['name'];
	}?>">
    <span class="error">* <?php echo $namerr;?></span></div>
  <div><label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php if (isset($_POST['email'])) {
		echo $_POST['email'];
	}?>">
    <span class="error">* <?php echo $emailerr;?></span></div>
  <div><label for="phone">Phone number:</label>
    <input type="tel" id="phone" name="phone" value="<?php if (isset($_POST['phone'])) {
		echo $_POST['phone'];
	}?>">
    <span class="error">* <?php echo $phonerr;?></span></div>
  <div><label for="compref">What is your communication preference?</label>
  <input type="radio" id="email" name="compref" <?php if (isset($_POST['compref']) && $_POST['compref'] == "E-mail") echo "checked";?> value="E-mail">
    <label for="email">E-mail</label>
  <input type="radio" id="telephone" name="compref" <?php if (isset($_POST['compref']) && $_POST['compref'] == "Telephone") echo "checked";?> value="Telephone">
    <label for="telephone">Telephone</label>
    <span class="error">* <?php echo $compreferr;?></span></div>
  <div><textarea id="mess" name="mess" rows="8" cols="50" placeholder= "Tell us why you want to contact us!"><?php if (isset($_POST['mess'])) {
	  echo $_POST['mess'];
  };?></textarea>
  <span class="error">* <?php echo $messerr ?></div>
  <input type="submit" value="Submit">
 </form>
 
</body>
</html>