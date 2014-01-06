<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporteControlador extends CI_Controller {

    
    /*Funcion Principal del controlador*/
    public function index(){
       
        $this->set_session('mensaje', NULL);
        $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/generarReportes';
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
            $data['personal']=$this->personalSaludModelo->obtenerPersonalSalud();
            $this->load->view('plantilla', $data);
        
    }
    function reporteEstudiantesProgramaPDF(){
        $id=$this->uri->segment(3);
        $id=  str_replace('%20', ' ', $id);
        $titulo=$this->session->all_userdata();
        $t=  str_replace('<br />','', $titulo['titulo_reporte']);
        $this->load->model('citaModelo');

        $reporte=$this->citaModelo->estudiantesPorPrograma($id);
        $this->load->library('pdf');
        // Creacion del PDF
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new Pdf('L','mm','A4');
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle($titulo['titulo_reporte']);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Text(20, 30, $t);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno)
         */
        $this->pdf->Cell(15,7,'#','TBL',0,'C','1');
        $this->pdf->Cell(50,7,'PROGRAMA','TBL',0,'C','1');
        $this->pdf->Cell(80,7,'NUMERO DE ESTUDIANTES',1,0,'L','1');
        $this->pdf->Ln(7);
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        foreach ($reporte->result() as $rep) {
            // se imprime el numero actual y despues se incrementa el valor de $x en uno
            $this->pdf->Cell(15,5,$x++,1,0,'C',0);
            // Se imprimen los datos de cada alumno
            $this->pdf->Cell(50,5,$rep->nombre_programa,1,0,'L',0);
            $this->pdf->Cell(80,5,$rep->numero,1,0,'BL',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(5);
        }
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("reporte.pdf", 'I');

        
    }
    
    function reporteEstudiantesPorFechaPDF(){
        
        
        $titulo=$this->session->all_userdata();
        $t= explode('<br /><br />', $titulo['titulo_reporte']);
        $this->load->model('citaModelo');

        $reporte=$this->citaModelo->estudiantesPorFecha($this->uri->segment(3),$this->uri->segment(4));
        $this->load->library('pdf');
        // Creacion del PDF
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new Pdf('L','mm','A4');
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle($titulo['titulo_reporte']);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        
        $this->pdf->Text(75, 30, $t[0]);
        $this->pdf->Text(20, 40, 'Nombre:  '.$t[1]);
        $this->pdf->Text(20, 50, 'Fecha:     '.$t[2]);
        $this->pdf->Ln(25);
        
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno)
         */
        $this->pdf->Cell(15,7,'#','TBL',0,'C','1');
        $this->pdf->Cell(30,7,'IDENTIFICACION','TBL',0,'C','1');
        $this->pdf->Cell(50,7,'NOMBRE',1,0,'L','1');
        $this->pdf->Cell(30,7,'HORA',1,0,'L','1');
        $this->pdf->Cell(60,7,'OBSERVACIONES',1,0,'L','1');
        $this->pdf->Ln(7);
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        foreach ($reporte->result() as $rep) {
            // se imprime el numero actual y despues se incrementa el valor de $x en uno
            $this->pdf->Cell(15,10,$x++,1,0,'C',0);
            // Se imprimen los datos de cada alumno
            $this->pdf->Cell(30,10,$rep->identificacion,1,0,'L',0);
            $this->pdf->Cell(50,10,$rep->primer_nombre.' '.$rep->primer_apellido,1,0,'BL',0);
            $this->pdf->Cell(30,10,$rep->hora_inicio,1,0,'BL',0);
            $this->pdf->MultiCell(60,10,$rep->observaciones,1,0,'BL',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(5);
        }
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("reporte.pdf", 'I');
        
    }
    
    function reporteEstudiantesFacultadPDF(){
        $id=$this->uri->segment(3);
        $id=  str_replace('%20', ' ', $id);
        $titulo=$this->session->all_userdata();
        $t=  str_replace('<br />','', $titulo['titulo_reporte']);
        $this->load->model('citaModelo');

        $reporte=$this->citaModelo->estudiantesPorFacultad($id);
        $this->load->library('pdf');
        // Creacion del PDF
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new Pdf('L','mm','A4');
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle($titulo['titulo_reporte']);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Text(20, 30, $t);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno)
         */
        $this->pdf->Cell(15,7,'#','TBL',0,'C','1');
        $this->pdf->Cell(50,7,'FACULTAD','TBL',0,'C','1');
        $this->pdf->Cell(80,7,'NUMERO DE ESTUDIANTES',1,0,'L','1');
        $this->pdf->Ln(7);
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        foreach ($reporte->result() as $rep) {
            // se imprime el numero actual y despues se incrementa el valor de $x en uno
            $this->pdf->Cell(15,5,$x++,1,0,'C',0);
            // Se imprimen los datos de cada alumno
            $this->pdf->Cell(50,5,$rep->nombre_facultad,1,0,'L',0);
            $this->pdf->Cell(80,5,$rep->numero,1,0,'BL',0);
            //Se agrega un salto de linea
            $this->pdf->Ln(5);
        }
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("reporte.pdf", 'I');
        
    }
    //funciones para acceder y modificar las variables de session
    public function set_session($var,$cont=NULL){
        $this->session->set_userdata($var, $cont);
    }
    public function get_session(){
        return $this->session->all_userdata();
    }
}
?>
