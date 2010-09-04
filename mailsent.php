<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de | Mail sent"; 
$pagedesc = "Thank you for your feedback."; 
require ('includes/config.php');
require ('includes/dbconnect.php');
require ('includes/functions.php');

?>
<?php include ('includes/head.php'); ?>
<body>
	<div class="container">
	
<?php include ('includes/header.php'); ?>

<?php include ('includes/nav.php'); ?>
		
		<div class="content">
        	<h1><a href="http://minifi.de/"><img src="images/minifide.png" width="108" height="27" alt="Minifi.de" /></a></h1>
            <h2>Mail sent</h2>
            <p style="height:140px;">Thank you for your feedback.</p>
        
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>