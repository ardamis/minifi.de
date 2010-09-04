<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $pagetitle; ?></title>
	<meta name="Description" content="<?php echo $pagedesc; ?>" />
	<meta name="Copyright" content="Copyright <?php echo date('Y'); ?> Minifi.de. All Rights Reserved" />
<?php
// Sniff out mobile browsers and adjust header
if(eregi('up.browser|up.link|windows ce|iemobile|mini|mmp|symbian|midp|wap|phone|pocket|mobile|pda|psp',$_SERVER['HTTP_USER_AGENT'])){
	echo '<link rel="stylesheet" href="css/mobilestyle.css" type="text/css" />';
	echo '<meta name="MobileOptimized" content="320" />';
} else {
	echo '<link rel="stylesheet" href="css/style.css" type="text/css" />';
} ?>

<script type="text/javascript">
window.google_analytics_uacct = "UA-167063-3";
</script>
</head>