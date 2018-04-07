<!-- 404 page. -->
<head>
	<meta name="author" content="ld0">
</head>

<?php


	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');


	echo nl2br("\n");
	echo "404 Error - page does not exist! ";
	echo "<a href=/index.php?>Click here</a>";  
	echo " to return home.";
	echo nl2br("\n");
?>
