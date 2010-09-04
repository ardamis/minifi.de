<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de | Terms and Conditions of Use"; 
$pagedesc = "Minifi.de's Terms and Conditions of Use."; 
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
            <h2>Terms &amp; Conditions of Use</h2>
            <p>Minifi.de may NOT be used for the following:</p>
            
            	<ul>
                	<li>Creating URLs for use in unsolicited advertising, including, but not limited to, email and forum posts (i.e. do not use for SPAM purposes)</li>
                	<li>Linking to any file or website depicting actual or simulated child pornography</li>
                	<li>Linking to any content or any other activity which is illegal in your area</li>
                	<li>Linking to other sites that also offer URL shortening/redirection (because creating a "chain" of redirects is often an attempt to hide malicious use, and also wastes bandwidth) - most of these should be automatically blocked anyway</li>
                </ul>
                
            <p>We reserve the right to remove any shortened URLs which we deem to have violated our terms and conditions, or that we believe violate the spirit of our terms or of fair usage (at our discretion).  We may, if we choose, report use that is forbidden by our terms and conditions to the relevant governmental or law enforcement agencies, including relevant information such as the IP address of the service requestor.  We also reserve the right to block any abusers from using our service in the future.  In addition, shortened URLs may be removed retroactively if they later appear on any of the blacklists that Minifi.de consults.</p>
            
            <h3>Excessive usage</h3>
            <p>We ask that you limit usage of our service to "reasonable" levels (reasonable usage is currently considered to be creating up to 1,000 new shortened URLs from a single IP address in a day or visiting up to 5,000 shortened URLs from a single IP address in a day). We reserve the right to remove shortened URLs from our service and/or block the abuser from our service temporarily or permanently when usage exceeds these levels.</p>
            
            <h3>Warranty and liability</h3>
            <p>Minifi.de is provided as a free service, and as such carries no warranty of any kind.  Minifi.de is not liable for any loss or problem you might suffer due to using the service.  This includes losses in the event that the service stops operating, is unavailable or slow, suffers data loss, or any other issue which might be considered detrimental to you.</p>
            
            <h3>Reliability</h3>
            <p>We strive for 100% uptime, but do not guarantee any level of service at this stage.</p>
            
            <h3>Privacy</h3>
            <p>We do not collect any personally identifying information from users of this website.  We do store technical information necessary to provide our URL shortening service, such as the original long URLs.  We may also store the IP addresses of computers using the Minifi.de service (and similar usage information such as web browser/resolution) for the sole purposes of identifying abuse of the service and tracking anonymous usage trends.  This information will not be made available to third parties.</p>
            
            <p>We may check submitted URLs and user IP addresses against blacklists to help prevent spam.  These blacklists may be operated by third parties.</p>
            
            <p>URLs shortened by our website are not private and should not be treated as such.  Third parties could easily guess the short URL that you are using, so you should not use Minifi.de to link to sensitive or secure data.</p>
            
            <p>Third party advertising may be included on the site.  Such advertisers may use technologies such as cookies, JavaScript, or web beacons which may allow them to access information such as your IP address, ISP, browser etc. to be used in the course of displaying advertising or selecting advertising to display.  You can choose to selectively turn off cookies and JavaScript in your browser settings, although this may affect your ability to interact with certain websites.</p>
        
		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>