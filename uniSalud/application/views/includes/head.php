<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<meta charset="utf-8">
<link rel="stylesheet" href="http://localhost/uniSalud/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="http://localhost/uniSalud/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="http://localhost/uniSalud/css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="http://localhost/uniSalud/css/stylesheet.css" type="text/css" media="all">

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/cufon-yui.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/cufon-replace.js"></script> 
<script type="text/javascript" src="http://localhost/uniSalud/js/Myriad_Pro_300.font.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/Myriad_Pro_400.font.js"></script>
<script type="text/javascript" src="http://localhost/uniSalud/js/funciones.js"></script>
<script language="javascript">
            $(document).ready(function(){ 
                $( "#fecha_nac" ).datepicker({
                    showOn: 'both',
                    buttonImage: 'http://localhost/unisalud/images/calendar.png',
                    buttonImageOnly: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    //numberOfMonths: 2,
                    onSelect: function(textoFecha, objDatepicker){
                        $("#mensaje").html("<p>Has seleccionado: " + textoFecha + "</p>");
                    }
                });    
            })    
        </script>
        <script>
            jQuery(function($){
                $.datepicker.regional['es'] = {
                    closeText: 'Cerrar',
                    prevText: '<Ant',
                    nextText: 'Sig>',
                    currentText: 'Hoy',
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                    weekHeader: 'Sm',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''
                };
                $.datepicker.setDefaults($.datepicker.regional['es']);
            });
        </script>    
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