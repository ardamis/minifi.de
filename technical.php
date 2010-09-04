<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de | How it works"; 
$pagedesc = "How this URL shortener works."; 
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
            <h2>What it does</h2>
            <h3>Shorten a URL</h3>
            <p>Paste any valid URL into the input field and click the Minify button to generate a shortened URL.</p>
            
            <h3>Lookup a long URL</h3>
            <p>Paste a URL shortened by Minifi.de (ex: http://minifi.de/a3m) into the input field and the submit button will change to something like "Decode this URL".  Click the button to look up the long URL without actually visiting it.</p>
            
            <h3>Submission via a toolbar link</h3>
            <p>Drag this link to your browser toolbar: <a href="javascript:void(location.href='http://minifi.de/api.php?longurl='+location.href)"  onmouseover="window.status='';return true;" onClick="return false">Minifi.de</a>.  Click on the link to create a shortened URL for the current page.</p>
        
            <h2>How it works</h2>
            <p>Minifi.de uses three components: some simple scripting, an .htaccess file, and a database.</p>
            
            <h3>The scripting</h3>
            <p>When you submit a long URL to be shortened, the processing script first does some validation, including checking that the URL is valid and that the page returns an HTTP status code of 200.  If everything checks out OK, it generates the alphanumeric string and sends everything to the database.  Then it assembles the shortened URL and displays it.</p>
            
            <p>When you use the shortened URL (i.e., request a redirection to the long URL), the script again does some validation, uses the alphanumeric string to look up the corresponding long URL in the database, and then redirects the browser and sends the proper HTTP Status Code: 301 Moved Permanently.</p>
            
            <h3>The .htaccess file</h3>
            <p>The .htaccess file is half of the redirection behavior.  When you access a shortened URL by entering it into a browser, the .htaccess file sends the characters after the trailing slash in <strong>http://minifi.de/</strong> to the processing script.</p>
            
            <h3>The database</h3>
            <p>The database stores a record of each long URL, the corresponding short URL, and some other information, such as the datetime the short URL was created, the IP address of the device making the request, etc.</p>
            
            <h2>The devil is in the details</h2>
            <p>At the risk of exposing the inner workings of my application, here's how I developed this.</p>
            <p>The first step was to figure out how to generate the short URL.  The easiest way would be to use a hash function, like MD5, to create a string of 'random' characters, then trim that down to 4 or 5.  But I was never comfortable with this system.  For one thing, the likelihood of collisions occurring in the random hash increases as the length of the random string decreases.  This means that in order to keep the chances of two identical strings being generated reasonably remote, I'd have to use at least 4 (and preferably 5) characters.  For another, the <a href="http://en.wikipedia.org/wiki/Pigeonhole_principle">pigeonhole principle</a> states that if I limited my string to 3 characters, I would run out of unique possibilities after generating more than 238,328 strings.  In all probability, of course, by the time I generated 238,328 3-character strings, I'd have gotten lots of duplicates.</p>
            <p>Not at all satisfied with those constraints, I decided to use a predictable alphanumeric string instead of random characters, settling on a base 62 numbering system that uses the characters 0-9, A-Z, and a-z.  For the first 3,844 URLs generated, the base 62 system can create very short strings (1-2 characters) that remain unique.  I don't really expect this thing to take off like tinyurl.com, is.gd, or bit.ly, but still... I like knowing that I can generate 238,328 <em>guaranteed unique</em> 20-character URLs.</p>
            <p>That done, the next thing to do was set up the .htaccess file to grab the  characters after the trailing slash in <strong>http://minifi.de/</strong> and send them to the processing script.  This proved more difficult than I had anticipated.  It was very easy to make a RewriteRule that would look for a character and send everything following it to the script, but I certainly didn't want to bloat the URL with an otherwise useless character.  I kept trying to identify the slash character itself, or just grab everything after it, but these methods either did not work at all or caused undesirable results.</p>
            <p>After digging around, I figured out something that seemed to work:</p>
            <pre><code>RewriteCond %{REQUEST_URI} !\.
RewriteRule ^([0-9A-Za-z]{1,5})$ /api.php?url=$1 [NC,L]</code></pre>
			<p>These two lines look for any URI that does not contain a dot (.) and sends the first 1 to 5 characters after the trailing slash to the URL rewriter.</p>
            <p>The last thing to set up was the database.  Initially, I thought that the database would be pretty straight-forward &#8212; just create a record with the long URL and the alphanumeric code, and maybe the datetime of the conversion and IP address of the requestor.  But as I thought about it more, I decided that I didn't need, and wouldn't want, to search for the code string in the database.  It would be faster and more simple to just convert between base 10 and base 62 as it was needed, and perform the look ups on the numerical row ID, which is set to AUTO_INCREMENT and is indexed as a PRIMARY KEY.  So here are a few more reasons not to use random strings: with a calculable code, the long URL look ups will be faster and less expensive, and the code string doesn't need to be in the database at all.</p>
            <p>I also had to do as much spam-proofing and hardening as I could, performing some sensible validation on the URL, verifying that the page actually exists, and properly encoding and escaping characters here and there.</p>
        
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>