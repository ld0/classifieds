<!-- Confirm a post. -->

<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Confirm a post">

</head>

<?php

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

    // Display errors- turn off in production.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>


<?php


    // Get the temporary database to copy the posting from.
    function gettempDB(){
        $db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/includes/db/unoclasstemp.db');
        return $db;
    }

    // Get the permanent database to copy the posting to.
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
    
    // Get the link visited. 
//    $link = $_GET['page'];

//    $link=test_input($link);   

    $letter = "";
    // If there is data left after stripping any invalid or unwanted characters
    if ((strlen($link) > 0)){
	// Get the temporary database
        $tempdb = gettempDB();
        // Prepare the query.
        $sql="SELECT * FROM [post] WHERE link LIKE '%$link%'"; 
        // Get the post info from the temporary database. 
        $result=$tempdb->query($sql) or die('Error, mysql failed upon query: ' . mysql_error());
        // If there is info, or if the post has not expired yet. 
	if ($result){
                // Get everything from the results.
                $row = $result->fetchArray();
                while (!empty($row)){
                        // Save the values.
                        $title=$row['title'];
			$descr=$row['descr'];
			$category=$row['category']; 
                        $email=$row['email']; 
                        $price=$row['price'];
                        // Save the old link, for use in copying images.
                        $oldlink=$row['link'];
                        // Initialize the number of reports to 0, and the date to current system date and time.
    			$report=0;
    			$date = date('Y-m-d H:i:s');
                        $row = $result->fetchArray();    

		}
        if (strlen($oldlink) == 0){
            echo "Problem with old link. title " . $title . " category " . $category;
            die;
        }
        // Get the permanent database. 
    	$db = getDB();
        // Send the command.
        $sql = "INSERT INTO post (descr, date, numreports, category, email, price, title) VALUES ('$descr', '$date', '$report', '$category', '$email', '$price', '$title');";

        $db->exec($sql) or die('Error, mysql failed upon exec: ' . mysql_error());  	
        // Get the new link (it's autoincremented). lastInsertRowID is safe for multiple processes. 
	$newlink= $db->lastInsertRowID();
        // Get the address of the old picture. 
        $oldpic = $_SERVER['DOCUMENT_ROOT'] . 'includes/images/temp/' . $oldlink;
        // If the old picture exists. 
        if (file_exists($oldpic)){
            // Make an address for the new picture. 
            $newpic = $_SERVER['DOCUMENT_ROOT'] . 'includes/images/perm/' . $newlink;
            // The PHP rename function is like a cut and paste. 
            if (!rename($oldpic, $newpic)){
                //echo "error upon pic creation";
            }
            else{
                //echo "file " . $newpic . " was succesfuly created.";
            }
        }
        else{
            // echo "file does not exist " . $oldpic;
        }
        // Redirect to the success page. 
	header("Location: /index.php?page=confirm_success");
    	die();

        }
        else{
            echo "Sorry, your post has already reached its 24 hr expiration period. Please resubmit your posting.";
        }
}	
?>
