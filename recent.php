<?php 
// define page-specific and other variables
$pageid = "recent"; 
$pagetitle = "Minifi.de | Recent URLs"; 
$pagedesc = "A list of the most recently generated URLs."; 
require ('includes/config.php');
require ('includes/dbconnect.php');
require ('includes/functions.php');

// Get the last inserted row ID
$query = "SELECT LAST_INSERT_ID() id";
$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
	$id = $row['id'];
}
$upperlimit = $id;
if ($id > 20) {
	$start = $id - 20;
} else {
	$start = 0;
}
// Get the list of tickets from the database
$query = sprintf("SELECT * FROM urls WHERE id >= '%d' ORDER BY id DESC LIMIT 20",
		$start);
$result = mysql_query($query) or die(mysql_error());

?>
<?php include ('includes/head.php'); ?>
<body>
	<div class="container">
	
<?php include ('includes/header.php'); ?>

<?php include ('includes/nav.php'); ?>
		
		<div class="content">
        	<h1><a href="http://minifi.de/"><img src="images/minifide.png" width="108" height="27" alt="Minifi.de" /></a></h1>
			<p>For your amusement, we present a list of the most recently generated URLs.</p>
            
            <table cellpadding="2" cellspacing="2">
            	<tr>
                	<th>ID</th>
                	<th>Short URL</th>
                	<th>Date Created</th>
                	<th>IP Address</th>
                	<th>Requests</th>
                </tr>

<?php
	while($row = mysql_fetch_array($result)) {
	// Print out the contents of each record into a table row
	$id = $row['id'];
	echo "<tr>\n";
	echo "<td>" . $id . "</td>";
	echo "<td><a href=\"http://minifi.de/" . $row['shortcode'] . "\" title=\"" . $row['longurl'] . "\">http://minifi.de/" . $row['shortcode'] . "</a></td>";
//	echo "<td><a href=\"" . $row['longurl'] . "\">" . $row['longurl'] . "</a></td>";
	echo "<td>" . $row['created'] . "</td>";
	echo "<td>" . long2ip($row['ip']) . "</td>";
	echo "<td>" . $row['requests'] . "</td>";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>&nbsp;</td>";
	echo "<td colspan=\"4\">" . $row['longurl'] . "</td>";
	echo "</tr>\n";
	}
?>

			</table>
        
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>