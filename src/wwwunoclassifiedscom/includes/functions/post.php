<!-- PHP form for posting. Redirects to the image submission page -->
<!-- This works by relying on a few things- error messages and a boolean value for complete. -->
<!-- If an element does not meet the requirements the error message will be set and the form will be marked as incomplete. -->

<head>

	<meta name="author" content="ld0">
        <meta name="description" content="Post an ad">

</head>
<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
    // Display erorrs. Turn off once the website is live.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $category = htmlspecialchars($_POST['category']);
    
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

// Initializing variables
$titleErr = $emailErr = $priceErr = $descrErr = $websiteErr = $categoryErr = $title = $email = $descr = "";
$price = " ";
$complete = TRUE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the title is present.  
    if (empty($_POST["title"])) {
        $titleErr = "Title is required";
        $complete=FALSE;
    } else {
        $title = test_input($_POST["title"]);
        if ($complete){
            $complete = TRUE;
        }
    }
  
    // Check if the email is present.
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $complete=FALSE;
        } else {
        $email = test_input($_POST["email"]);
        // Check if email address is a valid address.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $complete=FALSE;
        }
        // Check if a UNO address is present. 
        else {
            $explodedEmail = explode('@', $email);
            $domain = array_pop($explodedEmail);
            if ($domain != "uno.edu"){
                $emailErr = "UNO email required";
                $complete=FALSE;
            }
            else{
        if ($complete){
            $complete = TRUE;
        }
            }
            
	 }
    }  
    // Check if the price is present.
    if (empty($_POST["price"])) {
        $price = " ";
        if ($complete){
            $complete = TRUE;
        }
    } else {
        $price = test_input($_POST["price"]);
        // Check if the price entered is valid.
	if (!is_numeric($price) && (strlen(trim($price)) != 0)){
            $priceErr = "Price must be numeric only.";
            $complete=FALSE;
        }
        else{
        if ($complete){
            $complete = TRUE;
        }
        }
    }

    // Check if the post description is present.
    if (empty($_POST["descr"])) {
        $descrErr = "Description is required";
        $complete=FALSE;
    } else {
        $descr = test_input($_POST["descr"]);
        if ($complete){
            $complete = TRUE;
        }
    }
    

}
// Helper function used to take care of sent data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<h2>Post</h2>
You are posting under <?php echo $category ?>. 
<p><span class="error">* required field.</span></p>
<form method="post" action=""> 
    
    Post title: <input type="text" name="title" value="<?php echo $title;?>">
    <span class="error">* <?php echo $titleErr;?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
    <?php 
    if ($category !== "Gym Partners" && $category !== "Study Partners and Groups"){ ?>
    Price: $<input type="text" name="price" value="<?php echo $price;?>">

    <span class="error"><?php echo $priceErr;?></span> <?php
    }?>
    <br><br>
    Post description: <textarea name="descr" rows="5" cols="40"><?php echo $descr;?></textarea>
    <span class="error">* <?php echo $descrErr;?></span>
    <br><br>

<!--
    <input type="radio" name="category" <?php if (isset($category) && $category=="sale") echo "checked";?>  value="sale">For sale
    <input type="radio" name="category" <?php if (isset($category) && $category=="pers") echo "checked";?>  value="pers">Personals
    <span class="error">* <?php echo $categoryErr;?></span>
<-->

<input name="category" type="hidden" value="<?php echo $category; ?>">
    <br><br>
    <input type="submit" name="submit" value="Submit" >
   
</form>

<?php
    if ($complete){    
    
    /**
     * Initialize the number of reports set to 0.
     * Set the date as specified by the system time.
     */
    $report=0;
    $date = date('Y-m-d H:i:s');
  
    $db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/includes/db/unoclasstemp.db');
    $sql = "INSERT INTO post (descr, date, numreports, category, email, price, title) VALUES ('$descr', '$date', '$report', '$category', '$email', '$price', '$title');";
    
    $db->exec($sql) or die ("Error, mysql failed upon exec: " . mysql_error());

    // Send out an email
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/email/email.php');
    $to = $email;
    $subject = "Confirm post at UNO Classifieds";

    // Get the new link. lastInsertRowID is multiple processes safe.    
    $link= $db->lastInsertRowID();
    // Build the clickable link.
    $message = "http://www.unoclassifieds.com/index.php?confirmation=" . $link;
    $name = "Poster";
    //Send the email.
    echo sendmail($to, $subject, $message, $name, TRUE);     

    // Go to the photo upload page. 
    header("Location: /index.php?page=photo");
    die();
    
    $complete=FALSE;

    }
    
?>

</body>
</html>
