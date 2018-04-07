<!-- Finish uploading the photo. -->

<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Accept a photo upload">

</head>

<?php 
        // Display error messages. Turn off in production.
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

        $link = htmlspecialchars($_POST['link']);

        $valid_file;
// If there was a file
if($_FILES['photo']['name']){
	// If no errors...
	if(!$_FILES['photo']['error']){
                // It's a valid file
                $valid_file = true;
                // If the photo is greater than 1 MB
		if($_FILES['photo']['size'] > (1024000)){
			$valid_file = false;
			$message = 'Error.  Your file\'s size is too large.';
                        header("Location: /index.php?page=photo");
                        //die();
		}
		
		// If the file has passed the test
		if($valid_file){

                        $imageFileType = pathinfo($_FILES['photo']['tmp_name'],PATHINFO_EXTENSION);
                        // Make a place for the new picture.
                        $target_file = $_SERVER['DOCUMENT_ROOT'] . 'includes/images/temp/' . $link . $imageFileType;
                        
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                            chmod($target_file, 0775); 
                            echo "Your file has been uploaded. ";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                            //header("Location: /index.php?page=photo");
                            //die();
                        }  
 
		}
	}

}

    // Whether or not there was a photo
    echo "Thanks for posting! You will receive an email confirmation which requires you to confirm in order to have the post live on the site. Confirmations will expire in 24 hours.";
    die();

        
        ?>
