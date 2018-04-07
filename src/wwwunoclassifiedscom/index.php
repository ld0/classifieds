<!-- Main page -->


<head>

	<meta name="author" content="ld0">

</head>

<?php
        
require_once 'includes/structure/header.php';
require_once 'includes/structure/footer.php';
require_once 'includes/structure/error.php';
        
$page = isset( $_GET['page'] ) ? $_GET['page'] : false;

if ( !empty( $page ) ) {
    switch ( $page ) {
        case 'categories':
            $title = 'Categories';
            $template = 'includes/views/' . $page . '.php';
            break;

        case 'personals':
            $title = 'Personals';
            $template = 'includes/views/' . $page . '.php';
            break;

        case 'sale':
            $title = 'Sale';
            $template = 'includes/views/' . $page . '.php';
            break;

        case 'post1':
            $title = 'Post';
//            $template = 'includes/functions/' . $page . '.php';
            $template = 'includes/functions/post1.php';
            break;
        
        case 'post2':
            $title = 'Post';
            $template = 'includes/functions/post2.php';
            break;
        
        case 'post':
            $title = 'Post';
            $template = 'includes/functions/post.php';
            break;
          
        case 'search':
            $title = 'Search';
            $template = 'includes/functions/' . $page . '.php';
            break;        
        
        case 'search_submit':
            $title = 'Search';
            $template = 'includes/functions/search_submit.php';
            break;

        case 'photo':
            $title = 'Photo';
            $template = 'includes/functions/photo_upload.php';
            break;
        
        case 'photo_accept':
            $title = 'Photo';
            $template = 'includes/functions/photo_accept.php';
            break;
        
        case 'confirm_success':
            $title = 'Success';
            $template = 'includes/views/postsuccess.php';
            break;
        
        case 'display':
            $title = 'Display';
            $template = 'includes/views/' . $page . '.php';
            break;   
        
        case 'report':
            $title = 'Report';
            $template = 'includes/structure/report.php';
            break;
        
        case 'report_submit':
            $title = 'Report';
            $template = 'includes/functions/' . $page . '.php';
            break;
        
        default:
            header("HTTP/1.0 404 Not Found");
            $template = 'includes/views/404.php';
            break;
    }
} else {
    $template = $template = 'includes/views/home.php';
}

$search = isset( $_GET['search'] ) ? $_GET['search'] : false;

if (!empty( $search )){
    $template = 'includes/functions/search_submit.php';
}

$category = isset( $_GET['category'] ) ? $_GET['category'] : false;

if (!empty( $category )){
      $template = 'includes/views/browse.php';
}

$display = isset( $_GET['display']) ? $_GET['display'] : false;

if (!empty($display)){
    $template = $_SERVER['DOCUMENT_ROOT'] . 'includes/views/display.php';
    $link = $display;
}

$confirmation = isset( $_GET['confirmation'] ) ? $_GET['confirmation'] : false;
if (!empty($confirmation)){
    $template = $_SERVER['DOCUMENT_ROOT'] . 'includes/functions/confirmation.php';
    $link = $confirmation;

}

require_once $template;
