<!-- Search the database. Used with search.php -->

<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Search through the database">

</head>

<?php 

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

    // Helper function used to take care of sent data
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Helper function to get the database. 
    function getDB(){
        $db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/includes/db/unoclass.db');
        return $db;
    }

    // Display errors- turn off in production   
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Boolean value for if the search term leads anywhere. 
    $found = FALSE;
    
    if(isset($_POST['submit'])){ 
        $descr=test_input($_POST['descr']);          

        // If there is data left after stripping any invalid or unwanted characters
        if ((strlen($descr) != 0)){
                // Get the database
                $db = getDB();                
                // Prepare the query - search both description and title fields
                $sql="SELECT * FROM [post] WHERE descr LIKE '%$descr%' OR title LIKE '%$descr%'"; 
                // Send the query
                $result=$db->query($sql) or die('Error, mysql failed upon query: ' . mysql_error());
                // Loop through the result, so all entries matching the string will be displayed
                $row = $result->fetchArray();
                // While there's still entries in the result
                while (!empty($row)){
                        // Save the values to display
                        $title=$row['title']; 
                        $email=$row['email']; 
                        $price=$row['price'];
                        // If there is a price listed, prepare it for displaying
                        if ($price !== " "){
                            $price="$" . $price;
                        }
                        // Links - to be used with display.php
                        $link=$row['link'];
                        // The "b" refers to the default of not displaying the email address
                        $link=$link . 'b';
                        // New line
                        echo nl2br("\n");
                        echo "<ul>\n"; 
                        echo "<li>" . "<a  href=\"/index.php?display=$link\">"  . "<b>" . $title . "</b>" . "\r\n" . $price . "<a href=\\" . $link . "</a></li>\n"; 
                        echo "</ul>"; 
                        $found=TRUE;
                        // continue 
                        $row = $result->fetchArray();    
                    }
                    // If nothing was found
                    if (!$found) {
                        echo nl2br("\n");
                        echo "No results found.";
                    }
                }
            // If no (valid)search query was entered. 
            else{ 
                    echo  "<p>Please enter a search query.</p>"; 
            }

} 

       
?>
