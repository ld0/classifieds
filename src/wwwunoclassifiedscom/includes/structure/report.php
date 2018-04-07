<!-- Report page. -->

<?php

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

?>


<html lang="en"><head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="author" content="ld0">

Are you sure you want to report this post? Report this post for:	

	<ul>
	<li>Spam</li>
	<li>Illegal sales or services offered</li>
	<li>Offensive content</li>
	</ul>

Thank you for helping keep this community safe!

<?php

   function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }    

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Get the link visited. 
    $link = $_POST['link'];
    $link=test_input($link);   
    $letter = "";

    // If there is data left after stripping any invalid or unwanted characters
    if ((strlen($link) > 0)){
			?>

                        <form  method="post" action="/index.php?page=report_submit"  id="report"> 
                                <input type="hidden" name="link" value="<?php echo $link;?>">
				<input type="submit" name="submit" value="Report this post"> 
			</form>

</html> <?php

}




