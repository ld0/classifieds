<!-- Second submenu of the post submission. -->

<head>
	<meta name="author" content="ld0">

</head>

<?php

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

	echo "Subcategory:";
        // Get the category from the POST data. 
  	$category = htmlspecialchars($_POST['category']);
        // If the category was sale, list the subcategory options for sale.
	if ($category === "sale"){
		?> <form action=<?php echo 'index.php?page=post'; ?> method="post">
		<select name="category">
  			<option value="Apartments and Housing">Apartments and Housing</option>
  			<option value="Books">Books</option>
  			<option value="Clothing">Clothing and Apparel</option>
  			<option value="Computers">Computers/Laptops and Parts</option>
  			<option value="Other">Other</option>
		</select>
		<input  type="submit" name="submit" value="Submit">  
		</form>
		<?php
	}
        // If the category was personals, list the subcategory options for personals.
	else if ($category === "personals"){
		?> <form action="index.php?page=post" method="post">
		<select name="category">
  			<option value="Gym Partners">Gym Partners</option>
  			<option value="Tutoring">Tutoring</option>
  			<option value="Study Partners and Groups">Study Partners/Groups</option>
		</select>
		<input type="submit" name="submit" value="Submit">  
		</form>
		<?php
	}
	else{
		require_once 'includes/views/404.php';	
	}
	
