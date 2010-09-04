<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de is another URL shortening service"; 
$pagedesc = "Minifi.de is another URL shortening service. Currently in beta development, it is fully functional, but the database will be wiped."; 
require ('includes/config.php');
require ('includes/dbconnect.php');
require ('includes/functions.php');

if (isset($_POST['ip'])) {
	$blacklist = ip_blacklist_add($_POST['ip']);
}

?>
<?php include ('includes/head.php'); ?>
<body>
	<div class="container">
	
<?php include ('includes/header.php'); ?>

<?php include ('includes/nav.php'); ?>
		
		<div class="content">
        	<h1><a href="http://minifi.de/"><img src="images/minifide.png" width="108" height="27" alt="Minifi.de" /></a></h1>
			<p>Add an IP address to the blacklist.</p>
        
        	<form action="ip-blacklist-add.php" method="post" id="minifierform">
            	<div>
                    <input type="text" id="ip" name="ip" />
                </div>
            </form>
                        
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>