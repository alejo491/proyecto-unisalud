<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<meta charset="utf-8">
<link rel="stylesheet" href="http://localhost/uniSalud/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="http://localhost/uniSalud/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="http://localhost/uniSalud/css/style.css" type="text/css" media="all">
<script type="text/javascript" src="http://localhost/uniSalud/js/jquery-1.4.2.js" ></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/cufon-yui.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/cufon-replace.js"></script> 
<script type="text/javascript" src="http://localhost/uniSalud/js/Myriad_Pro_300.font.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/Myriad_Pro_400.font.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/funciones.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
	<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<?php 
if(isset($output)){
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; 
}?>
</head>