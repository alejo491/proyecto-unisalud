<?php 
/*Plantilla de la Pagina, Aqui se cargan todos los contenidos*/
if(isset($output)){
    $this->load->view('includes/head',$output);
    $this->load->view($header,$output);
    $this->load->view('includes/content',$output);
    $this->load->view('includes/footer',$output);
}
else{
    $this->load->view('includes/head');
    $this->load->view($header);
    $this->load->view('includes/content');
    $this->load->view('includes/footer');
}
?>