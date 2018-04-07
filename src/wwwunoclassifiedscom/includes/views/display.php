<!-- Display SQL database entries, with the token key of the link of the post -->

<!doctype html>
	<html lang="en">
<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Display a queried entry">

</head>

<?php

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

	// Display errors, turn off in production.
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    	// Get the database 
    	function getDB(){
        	$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/includes/db/unoclass.db');
        	return $db;
    	}

    	// Helper function used to take care of sent data
    	function test_input($data) {
        	$data = trim($data);
        	$data = stripslashes($data);
        	$data = htmlspecialchars($data);
        	return $data;
    	}    

    	$valid=FALSE;
    	// Get the link visited. 
    	$link=test_input($link);   
    	$letter = "";
    	// If there is data left after stripping any invalid or unwanted characters
    	if ((strlen($link) > 1)){
        	// This is to get whether or not to display the email address. 
        	$letter = substr($link, -1);
        	$link = preg_replace("/[^0-9,.]/", "", $link);
        	$db = getDB();
        	// Get the post from the database with the link provided
        	$sql="SELECT * FROM [post] WHERE link LIKE '%$link%'"; 
        	$result=$db->query($sql) or die('Error, mysql failed upon query: ' . mysql_error());

		if ($result){
                	// Get everything from the results.
                	$row = $result->fetchArray();
                    	$title=$row['title']; 
                    	if ((strlen($title) != 0)){
                        	$email=$row['email']; 
                        $price=$row['price']; 
                        $link=$row['link'];
                        $category=$row['category'];
                        $description=$row['descr'];
                        $valid=TRUE;
                }
	    }	
	}
?>

<html>
    <head>
	<style>
	<?php include 'display.css'; ?>
	</style> 
    </head>
    <body>
        <h1>
<?php echo "<titl><i>$title</i></titl>"; ?></h1>


<?php
	if ($valid){
		// Display

		echo "<other>Category: " . $category . "</other>";
		echo nl2br("\n");	
		echo "	<title>$title</title><b></b>";
		echo nl2br("\n");
		echo "<other>Contact: </other>";
		// If "view email" is selected, the email address will display
             	if ($letter == 'b'){
//                	$l = "/includes/views/display.php?link=" . $link  . "a";
                        $l = "/index.php?display=$link"  . "a";

				?>
        <a href="<?php echo $l; ?>" ><other>View email</other></a>
				<?php

		}
             	else {
			// Try to have the page with email displayed not able to be indexed by search engines. 
                            ?> <META NAME="robots" CONTENT="noindex"> <?php
                            echo "<other>" . $email . "</other>";
                        }
          	if ($price !== " "){
          		echo "<other> Price: $" . $price . "</other>";
       		}
		echo nl2br("\n");
		echo "<other>Description:</other>";
		echo nl2br("\n");
		echo nl2br("\n");
		echo "<descr>$description</descr>";
		echo nl2br("\n");
		echo nl2br("\n");
                        
             	$image = '/includes/images/perm/' . $link;
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image)){
                            ?><img src= "<?php echo $image; ?>" alt="test"/><?php
			echo nl2br("\n");
                }
                        ?>
                                <form  method="post" action="index.php?page=report"  id="report"> 

                                <input type="hidden" name="link" value="<?php echo $link;?>">
				<input type="submit" name="submit" value="Report this post"> 
			</form>
                                        <?php
		}
    		else{
                        include $_SERVER['DOCUMENT_ROOT'] . 'includes/views/404.php';
                    }
		?>
 		

    </body>
</html>
