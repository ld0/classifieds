
<!-- Header file -->

<!doctype html>
<html lang="en">
    <head>

<style>
<?php include 'header.css'; ?>
</style>
        <meta charset="utf-8">
        <title>
<?php echo !empty( $title ) ? "$title | " : "" ?>University New Orleans Classifieds</title>

        
        
<?php	echo "<p><a href=/>UNO Classifieds</a></p><b></b>";
	$image = 'uno.jpg';
	echo nl2br("\n");
	echo '<div style="text-align: center"><b><img src="/uno.png" height="150" width="150"></div>'; 
?>



	<meta name="author" content="ld0">
	<meta name="description" content="University New Orleans Classifieds">
</head>
<body>
 <?php 	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/menu.php'); ?>
