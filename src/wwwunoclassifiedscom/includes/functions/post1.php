<?php

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

?>

	Category:
<form action=<?php echo 'index.php?page=post2'; ?> method="post">
	<select name="category">
  		<option value="sale">For sale</option>
  		<option value="personals">Personals</option>
	</select>
	<input  type="submit" name="submit" value="Submit">  
</form>
