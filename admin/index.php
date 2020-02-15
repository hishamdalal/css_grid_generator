<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
define('ADMIN', TRUE);
require_once 'login_system.php';
require_once '../inc/clean.php';
?>
<!DOCTYPE html>
<html lang="en" class="">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon-->
    <meta name="application-name" content="CSS Grid Generation administration" />

    <!-- Author Meta -->
    <meta name="author" content="HishamDalal">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>CSS Grid Generation Adminstration</title>

    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/main.css">

</head>

<body>
<?php

$login = new LoginSystem;

include '../inc/record_visitors.class.php';
$visitor = new recordVisitors();
$visitor->set_path('data');
$visitor->record();
#echo '<pre>';
#print_r($_SERVER);

$do = RemoveXSS(@$_GET['do']);
if($login->is_login()){
	echo $login->controls();
	
	include_once '../inc/record_visitors.class.php';
	$visitor = new recordVisitors();
	$visitor->set_path('data');
	
	switch($do){
		case 'logout': 
			$login->logout(); 
		break;
		
		case 'delete':
			$visitor->delete(RemoveXSS($_GET['file']));
			header("Location: index.php"); 
		break;
		
		case 'logout':
						$login->logout();
		break;
		
		case 'view':
			$file = RemoveXSS($_GET['file']);
			echo $visitor->get_record_data($file);
		break;
		
		default:
				
					echo 'Count:' . $visitor->get_count();
					echo '<br>';
					echo 	$visitor->show_record_files();
		break;
			
	}
}
else{
	
	switch($do){
		case 'login': 
			$login->login(); 
		break;

		default: 
			$login->form();
		break;
	}
}

?>

    <script src="../assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
    </script>

</body>

</html>