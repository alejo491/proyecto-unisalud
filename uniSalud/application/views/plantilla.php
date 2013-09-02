<?php 
/*Plantilla de la Pagina, Aqui se cargan todos los contenidos*/
$this->load->view('includes/head',$output);
$this->load->view($header,$output);
$this->load->view('includes/content',$output);
$this->load->view('includes/footer',$output);
?>