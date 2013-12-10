<?php
/**
 * Sharif Judge online judge
 * @file header.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?> - Sharif Judge</title>
	<meta content="text/html" charset="UTF-8">
	<link rel="icon" href="<?php echo base_url("assets/images/favicon.ico") ?>"/>
	<link rel="stylesheet" type='text/css' href="<?php echo base_url("assets/styles/$style") ?>"/>
	<link rel="stylesheet" type='text/css' href="<?php echo base_url("assets/styles/splashy.css") ?>"/>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.10.2.min.js") ?>"></script>
	<!-- You can use google's cdn for loading jquery: -->
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-1.10.3.custom.min.js") ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url("assets/styles/flick/jquery-ui-1.10.3.custom.min.css") ?>"/>
	<script type="text/javascript" src="<?php echo base_url("assets/js/moment.min.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.hoverIntent.minified.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.cookie.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.ba-resize.min.js") ?>"></script>

	<script type="text/javascript" src="<?php echo base_url("assets/noty/jquery.noty.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/noty/layouts/center.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/noty/layouts/bottomRight.js") ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/noty/themes/default.js") ?>"></script>

	<link rel='stylesheet' type='text/css' href='<?php echo base_url("assets/nano_scroller/nanoscroller.css") ?>'/>
	<script type='text/javascript' src="<?php echo base_url("assets/nano_scroller/jquery.nanoscroller.min.js") ?>"></script>

</head>
<script>
shj={};
shj.site_url = '<?php echo rtrim(site_url(),'/').'/' ?>';
shj.base_url = '<?php echo rtrim(base_url(),'/').'/' ?>';
shj.csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
// difference of server and browser time:
shj.offset = moment('<?php echo date("Y-m-d H:i:s", shj_now()); ?>').diff(moment());
shj.time = moment();
shj.finish_time = moment("<?php echo $assignment['finish_time'] ?>");
shj.extra_time = moment.duration(<?php echo $assignment['extra_time'] ?>, 'seconds');
// notifications
shj.check_for_notifications = false;
shj.notif_check_delay = 30;
</script>
<script type="text/javascript" src="<?php echo base_url("assets/js/shj_functions.js") ?>"></script>
<body id="body">