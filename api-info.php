<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de | How to use our API"; 
$pagedesc = "How to use the Minifi.de API to submit and receive URLs."; 
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
            <h2>How to use our API</h2>
            <p>The Minifi.de API works alot like that of <a href="http://is.gd/">is.gd</a>.</p>
            
            <h3>Submitting a URL to be shortened</h3>
            <p>Set up your application to access a URL on minifi.de, passing the URL you wish to shorten via an HTTP GET request: http://minifi.de/api.php?longurl=http://www.example.com</p>
            
            <h3>Receiving the shortened URL</h3>
            <p>An HTTP response (web page) will be returned. If the request was successful, the body of the response will contain only the new shortened URL, in plain text.</p>
            
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>