<?php
require ('includes/config.php');
require ('includes/dbconnect.php');
require ('includes/functions.php');

if (isset($_GET['url'])) {
	// If the visitor is sent here by .htaccess, redirect to the longurl
	echo $shortcode = do_redirect($_GET['url']);
}

if (isset($_GET['longurl'])) {
	// If the visitor is submitting a longurl to be shortened, return just the shorturl
	echo $shortcode = generate_url($_GET['longurl']);
}
?>