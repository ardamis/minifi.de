<?php 
// define page-specific and other variables
$pageid = "index"; 
$pagetitle = "Minifi.de | Feedback"; 
$pagedesc = "Help make Minifi.de better by reporting bugs and leaving feedback."; 
require ('includes/config.php');
require ('includes/dbconnect.php');
require ('includes/functions.php');

$submitted_timestamp  = time();
if (isset($_POST['timestamp']) && $submitted_timestamp - $_POST['timestamp'] > 30) {
// The form was submitted more than 30 seconds after page load - probably by a human being

// The recipient
$to = 'obbaty@gmail.com';

// The subject
$subject = $_POST['subject'];

// The message
$message = $_POST['name'] . "\r\n\n" . $_POST['email'] . "\r\n\n" . $_POST['feedback'];

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70);

// Additional headers
$headers = 'From: mail@minifi.de' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
// Send
mail($to, $subject, $message, $headers);

// Do some error handling
$error = 0;
}elseif($submitted_timestamp - $_POST['timestamp'] <= 30){
// The form was submitted within 30 seconds of page load - possible spam
$error = 1;
}

?>
<?php include ('includes/head.php'); ?>
<body>
	<div class="container">
	
<?php include ('includes/header.php'); ?>

<?php include ('includes/nav.php'); ?>
		
		<div class="content">
        	<h1><a href="http://minifi.de/"><img src="images/minifide.png" width="108" height="27" alt="Minifi.de" /></a></h1>
            <h2>Feedback</h2>
            
<?php if (isset($_POST['timestamp']) && $error == 0) { ?>

            <p>Thank you for your feedback.</p>

<?php } elseif(isset($_POST['timestamp']) && $error == 1) { ?>

            <p>The form was submitted within 30 seconds of page load.  Please use the Back button in your browser, wait 30 seconds, and resubmit the form.  This is an anti-spam method.</p>

<?php } else { ?>

            <p>Help me make Minifi.de better.</p>
        
			<form action="feedback.php" method="post" id="feedbackform" class="clearfix">
  			<div>
    			<input name="subject" type="hidden" value="Minifi.de Feedback" />
    			<input name="redirect" type="hidden" value="mailsent.php" />
                <input type="hidden" name="timestamp" id="timestamp" value="<?php echo time(); ?>" />
  			</div>
			
			<p><label for="name"><small>Name</small></label><input type="text" name="name" id="name" value="" size="22" tabindex="1" />
			</p>
			
			<p><label for="email"><small>Email</small></label><input type="text" name="email" id="email" value="" size="22" tabindex="2" />
			</p>
			
			<p><label for="feedback"><small>Feedback</small></label><textarea name="feedback" id="feedback" cols="100" rows="3" tabindex="3"></textarea></p>
			
			<p><input name="submit" type="submit" id="submit" value="Submit" tabindex="4" /></p>
			
			</form>
        
<?php } ?>

		</div><!-- end .content -->
		
<?php include ('includes/footer.php'); ?>