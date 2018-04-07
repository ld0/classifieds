<!-- Search for a post. Sends POST data to search_submit.php -->

<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Search through the database">
</head>

<!DOCTYPE html>

	Search for a post.
	<form  method="post" action=<?php echo 'index.php?page=search_submit'; ?>  id="searchform"> 
		<input  type="text" name="descr"> 
		<input  type="submit" name="submit" value="Search">  


	</form> 

</form> 
</html>
