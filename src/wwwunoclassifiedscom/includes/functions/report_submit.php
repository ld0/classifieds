<!-- Report a post for breaking the rules. After 5 reports, a post is deleted. -->

<head>

	<meta name="author" content="ld0">

</head>

<?php

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
    	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

    	// Display errors. turn off in production
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
    
    	// Get the link visited. 
    	$link = $_POST['link'];
    	$link=test_input($link);   
    	$letter = "";
    	// If there is data left after stripping any invalid or unwanted characters
    	if ((strlen($link) > 0)){
        	$db = getDB();
        	// Get all the post info matching the link.
        	$sql="SELECT * FROM [post] WHERE link LIKE '%$link%'"; 
        	$result=$db->query($sql) or die('Error, mysql failed upon query: ' . mysql_error());

		if ($result){
                	// Get everything from the results.
                	$row = $result->fetchArray();
			$numreports=$row['numreports'];
                	// If there are already 4 reports, delete the post from the database after sending an email.
                	if ($numreports == 4){
                    		require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/email/email.php');
                    		$email=$row['email'];
                    		$title=$row['title'];
                    		$to = $email;
                    		$subject = "Post deleted UNO Classifieds";
                    		$message = $title;
                                        
                    		$name = "Poster";
                    		// Send the email.
                    		sendmail($to, $subject, $message, $name, FALSE);  
                    		// Delete any accompanying picture.
                    		$pic = $_SERVER['DOCUMENT_ROOT'] . 'includes/images/temp/' . $link;
                    		// If a picture exists, delete it.  
                    		if (file_exists($pic)){
                   			unlink($pic);
                    		}
                    		// Now delete from the database. 
                    		$sql="DELETE FROM post WHERE link=$link;"; 
                    		$db->exec($sql) or die("Error upon writing to the database " . mysql_error());
                	}
                	else{
                    		// If the number of reports isn't 4 yet, increment the number of reports. 
                    		$numreports++;
                    		$sql="UPDATE post SET numreports=$numreports WHERE link=$link;";
                    		$db->exec($sql) or die("Error upon writing to the database " . mysql_error());
                	}
                	echo "Thank you for reporting this post. Report has been submitted.";
        	}
        	else{
                        include $_SERVER['DOCUMENT_ROOT'] . 'includes/views/404.php';
        	}
	}	
?>
