<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de is another URL shortening service"; 
$pagedesc = "Minifi.de is another URL shortening service. Currently in beta development, it is fully functional, but the database will be wiped."; 
require ('includes/config.php');
require ('includes/dbconnect.php');
require ('includes/functions.php');

if (isset($_POST['url'])) {
	$shorturl = generate_url($_POST['url']);
}

?>
<?php include ('includes/head.php'); ?>
<body>
	<div class="container">
	
<?php include ('includes/header.php'); ?>

<?php include ('includes/nav.php'); ?>
		
		<div class="content">
        	<h1><a href="http://minifi.de/"><img src="images/minifide.png" width="108" height="27" alt="Minifi.de" /></a></h1>
			<p>Minifi.de is another URL shortening service, and is currently in beta development.  It's functional, but the database <em>will be wiped</em> regularly, so I'd caution against using it for real tweets just yet.</p>
        
        	<form action="/" method="post" id="minifierform">
            	<div>
                    <input type="text" id="url" name="url" onFocus="decodeSwitch(); showLength();" />
                </div>
            	<div>
                	<p id="length"></p>
                    <input type="submit" id="submit" value="Minify" tabindex="1" />
                </div>
            	<div>
                    <textarea rows="1" cols="40" id="shorturl" tabindex="2" onClick="this.select();"><?php if ($shorturl) { echo $shorturl; } ?></textarea>
                </div>
            </form>
            
<script type="text/javascript"><!--//--><![CDATA[//><!--
// Set focus to the url field if no shorturl is displayed
if (document.getElementById('shorturl').value == '') {
	document.getElementById('url').focus();
}
function showLength()
{
	var l = document.getElementById('url').value.length;
	document.getElementById('length').innerHTML = l;
	setTimeout("showLength()",250);
}
function decodeSwitch()
{
	var u = document.getElementById('url').value.substr(0,17);
	if (u == "http://minifi.de/") {
		document.getElementById('submit').value = "Decode this URL";
	} else {
		document.getElementById('submit').value = "Minify";	
	}
	setTimeout("decodeSwitch()",250);
}
//--><!]]></script>
            
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>