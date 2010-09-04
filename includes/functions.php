<?php
function do_redirect($shortcode) {
	// Accepts the short code, looks up the long URL, and redirects the browser

	global $link;
	
	// Convert all applicable characters to HTML entities
	$shortcode = htmlentities($shortcode, ENT_QUOTES);
	
	// Reverse magic_quotes_gpc/magic_quotes_sybase effects on those vars if ON
	if(get_magic_quotes_gpc()) {
		$shortcode = stripslashes($shortcode);
	}
	
	// Debug
//	return $shortcode;

	// Convert the shortcode (base 62) into a integer (base 10)
	// The integer will correspond to the row number in the database
	$id = base10_convert($shortcode);
	
	// Debug
//	return $id;
	
	// Look up the long URL using the row number
	$query = sprintf("SELECT * FROM urls WHERE id = '%d'",
	$id);
	
	$result = mysql_query($query, $link) or die(mysql_error());
	
	// Check to see if this ID exists in the database
	if (mysql_num_rows($result) == 0) {
		// No record exists, send an error message
		header("Status: 500"); /* 500 Internal Server Error */
		echo "Error: The URL entered was not valid.";
		exit;
	}

	while ($row = mysql_fetch_array($result)) {
	// Convert all HTML entities to their applicable characters
		$longurl = html_entity_decode($row['longurl']);
		$requests = $row['requests'];
	}
	
	// Increment the number of requests by 1
	$requests++;
	
	// Save the new requests count to the database
	$query = sprintf("UPDATE urls SET requests = '%d' WHERE id = '%d'",
	$requests,
	$id);
	
	$result = mysql_query($query, $link) or die(mysql_error());
	
	// Debug
//	 return $longurl;

	// Do the redirect to the long URL as 301 Moved Permanently
	header("Location: " . $longurl . "",TRUE,301); 
	// Make sure that code below does not get executed when we redirect
	exit;
}

function generate_url($longurl) {
	// Accepts the long URL, generates a short URL, and saves everything to the database
	
	global $link;
	
	// Get the requester's IP address
	$ip = $_SERVER['REMOTE_ADDR'];
	
	// Convert all applicable characters to HTML entities
	$longurl = htmlentities($longurl, ENT_QUOTES);
	
	// Reverse magic_quotes_gpc/magic_quotes_sybase effects on those vars if ON
	if(get_magic_quotes_gpc()) {
		$longurl = stripslashes($longurl);
	}
	
	// Add the http:// protocol specifier if the http:// or https:// specifier does not already exist
	if (strtolower(substr($longurl, 0, 7)) != "http://" && strtolower(substr($longurl, 0, 8)) != "https://") { $longurl = "http://" . $longurl; }
	
	// Perform some sensible checks on the URL before querying the database
	if (strtolower(substr($longurl, 0, 17)) == "http://minifi.de/" || strtolower(substr($longurl, 0, 26)) == "http://minifide.localhost/") {
		// The user entered a shortened URL that we'll look up in hopes of returning a long URL, this is not a redirect, just a lookup
		$shorturl = do_lookup($longurl);
		return $shorturl;
	} elseif (!validate_url_construction($longurl)) {
		// Check that the url is properly constructed
		return "Error: The URL entered was not valid.";
	} elseif (!url_validate($longurl)){
		// We don't want to shorten URLs with a HTTP status code of 301 or any of the error codes
		// Check that the URL returns an acceptable HTTP status code (200 or 302)
		return "Error: The URL entered did not return an HTTP status code of 200.";
	} elseif (!ip_blacklist_check($ip)){
		// The IP address appears on the blacklist
		return "Error: The URL cannot be shortened.";
	} else {
		// This is a valid long URL, so shorten it
	
		// Create a new record for the url (in effect, reserve a row number)
		$increment = mysql_query("INSERT INTO urls () VALUES()") or die(mysql_error());
		// Get the row number created in the previous line
		$rowid = mysql_insert_id();
		
		// Convert the numeric rowid (base 10) to alphanumeric (base 36)
		// http://www.webmasterworld.com/php/3177787.htm
		// http://us3.php.net/manual/en/function.base-convert.php
		// I'd really prefer to use base 62, but it's not supported in PHP's base_convert function
//		$shortcode = base_convert($rowid, 10, 36);

		// A commenter at http://us2.php.net/manual/en/function.base-convert.php worked out base 62 conversions
		// More here: http://en.wikipedia.org/wiki/Base_62
		// Convert the ID into the base 62 shortcode
		$shortcode = base62_convert($rowid);
		
		// Escape special characters in a string for use in a SQL statement
		$query = sprintf("UPDATE urls SET shortcode = '%s', longurl = '%s', created = NOW(), ip = INET_ATON('%s'), requests = '0' WHERE id = '%d'",
		$shortcode,
		mysql_real_escape_string($longurl, $link),
		mysql_real_escape_string($ip, $link),
		$rowid);
		
		// Debug
//		echo $query;
	
		// Send it to the database
		$result = mysql_query($query, $link) or die(mysql_error());
		
		// Assemble the short URL (so it can be used in both live and dev environments)
		$shorturl = "http://" . $_SERVER["SERVER_NAME"] . "/" . $shortcode;
		
		return $shorturl;
	}
}

function do_lookup($url) {
	// Accepts a short URL and looks up the corresponding long URL
	// The user entered a shortened URL that we'll look up in hopes of returning a long URL, this is not a redirect, just a lookup
	
	global $link;
	
	// Extract the shortcode from the provided URL
	$shortcode = substr(strrchr($url, "/"), 1);
	// Convert the shortcode to an integer and save it as $id
	$id = base10_convert($shortcode);
	// Look up the long URL in the database using the row number as the ID
	$query = sprintf("SELECT * FROM urls WHERE id = '%d'",
	$id);
	
	// Query the database for the long URL
	$result = mysql_query($query, $link) or die(mysql_error());
	
	// Check to see if this ID exists in the database
	if (mysql_num_rows($result) == 0) {
		// No matching ID was found in the database; return an error message
		return "Error: The URL does not exist in the database.";
	exit;
	}

	while ($row = mysql_fetch_array($result)) {
		// Convert all HTML entities to their applicable characters
		$longurl = html_entity_decode($row['longurl']);
	}
	
	// Return the long URL
	return $longurl;
}

function base62_convert($num) {
	// Modified from http://us2.php.net/manual/en/function.base-convert.php (comment)
    $base = 62;
    $index = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $out = "";
    for ($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
        $a = floor($num / pow($base, $t));
        $out = $out . substr($index, $a, 1);
        $num = $num - ($a * pow($base, $t));
    }
    return $out;
}

function base10_convert($num) {
	// Modified from http://us2.php.net/manual/en/function.base-convert.php (comment)
    $base = 62;
    $index = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $out = "";
    $len = strlen($num) - 1;
    for ($t = 0; $t <= $len; $t++) {
        $out = $out + strpos($index, substr($num, $t, 1)) * pow($base, $len - $t);
    }
    return $out;
}

function validate_url_construction($url) {
	// Modified from http://scriptplayground.com/tutorials/php/Simple-Way-to-Validate-Links/ (comment) to accept commas in the query part
	
	$urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9,;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
	if (eregi($urlregex, $url)) {
		return true;
	} else {
		return false;
	}
}

function url_validate($link) {       
	// Modified from http://us3.php.net/fsockopen (comment) to accept 302 redirects, too
	$url_parts = @parse_url($link);
	if (empty($url_parts["host"])) return(false);

	if (!empty($url_parts["path"]))	{
		$documentpath = $url_parts["path"];
	}else{
		$documentpath = "/";
	}

	if (!empty($url_parts["query"])) {
		$documentpath .= "?" . $url_parts["query"];
	}

	$host = $url_parts["host"];
	$port = $url_parts["port"];
	// Now (HTTP-)GET $documentpath at $host";

	if (empty($port)) $port = "80";
	$socket = @fsockopen($host, $port, $errno, $errstr, 30);
	if (!$socket) {
		return(false);
	}else{
		fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
		$http_response = fgets($socket, 22);
	   
		if (strpos($http_response, "200") || strpos($http_response, "302")) {
			return(true);
			fclose($socket);
		}else{
//          echo "HTTP-Response: $http_response<br>";
			return(false);
		}
	}
}

function ip_blacklist_check($ip){
	// Check the IP against the blacklist
	
	global $link;
	
	$query = sprintf("SELECT * FROM ip_blacklist WHERE ip = INET_ATON('%s')",
	mysql_real_escape_string($ip, $link));
	
	$result = mysql_query($query, $link) or die(mysql_error());
	
	// Check to see if this IP exists in the database
	if (mysql_num_rows($result) == 0) {
		// No record exists, IP address is OK
		return true;
	} else {
		return false;
	}
}

function ip_blacklist_add($ip){
	// Add an IP to the blacklist
	
	global $link;
	
	$query = sprintf("INSERT INTO ip_blacklist (ip) VALUES(INET_ATON('%s'))",
	mysql_real_escape_string($ip, $link));
	$result = mysql_query($query, $link) or die(mysql_error());
}

?>