<!-- Upload a photo to the server. Used with photo_accept -->

<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Upload a photo">

</head>

<?php 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

        
    $db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/includes/db/unoclasstemp.db');

    // Get the last uploaded entry
    $sql="SELECT * FROM post ORDER BY link DESC LIMIT 1;"; 
    // Send the query to the database 
    $result=$db->query($sql) or die('Error, mysql failed upon query: ' . mysql_error());
    // Get its link
    $row = $result->fetchArray();
        $link=$row['link'];

    ?>


<form action=<?php echo 'index.php?page=photo_accept'; ?> method="post" enctype="multipart/form-data">
	Upload a photo (1MB size limit): <input type="file" name="photo" size="25" />
        <input name="link" type="hidden" value="<?php echo $link; ?>">

	<input type="submit" name="submit" value="Submit" />
</form>
