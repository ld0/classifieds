<!-- Browse the database. Used to display entries in a category. Similar functioning to the searches -->

<head>

	<meta name="author" content="ld0">

</head>

<?php 
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/error.php');

    	// Helper function used to take care of sent data
    	function test_input($data) {
        	$data = trim($data);
        	$data = stripslashes($data);
        	$data = htmlspecialchars($data);
        	return $data;
    	}
    
    	function getDB(){
        	$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/includes/db/unoclass.db');
        	return $db;
    	}
    	// Display errors, turn off in production.
    	ini_set('display_errors', 1);
    	ini_set('display_startup_errors', 1);
    	error_reporting(E_ALL);
    
    
    	$found = FALSE;
    
if(isset($_GET['category'])){ 
	$category=test_input($_GET['category']);          

    	// If there is data left after stripping any invalid or unwanted characters
    	if ((strlen($category) != 0)){
        	// If so, connect to the mysql database, and print out the error if it fails
        	$db = getDB();
        	// Get any posts under that category 
        	$sql="SELECT * FROM [post] WHERE category LIKE '%$category%'"; 
        	// Now use the mysql query 
        	$result=$db->query($sql) or die('Error, mysql failed upon query: ' . mysql_error());
        	// Loop through the result, so all results will be displayed
        	$row = $result->fetchArray();
        	while (!empty($row)){
            		$title=$row['title']; 
            		$descr=$row['descr'];
            		$email=$row['email']; 
            		$price=$row['price'];
            		if ($price !== " "){
                		$price="$" . $price;
            		}
            	$link=$row['link'];
            	$link=$link . 'b';
            	echo nl2br("\n");
            	echo "<ul>\n"; 
		
           	//echo "<li>" . "<a  href=\"/includes/views/display.php?link=$link\">"  . "<b>" . $title . "</b>" . "\r\n" . $price . "<a href=\\" . $link . "</a></li>\n"; 
           	echo "<li>" . "<a  href=\"/index.php?display=$link\">"  . "<b>" . $title . "</b>" . "\r\n" . $price . "<a href=\\" . $link . "</a></li>\n"; 
            	echo "</ul>"; 
            	$found=TRUE;
            	$row = $result->fetchArray();    
            	}
	// If nothing was found
        if (!$found) {
		echo nl2br("\n");
            	echo "No posts under this category.";
        }
}

} 

       
?>

