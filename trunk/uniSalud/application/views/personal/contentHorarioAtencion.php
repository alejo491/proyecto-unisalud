<section id="content">
    <div><br/>
        <h4 style="color: #000;"><b>Informacion Personal:</b></h4>
        <h4 style="color: #000;"><b>Nombre:  </b><?php echo $medico->primer_nombre." ".$medico->primer_apellido;?></h4>
        <h4 style="color: #000;"><b>Numero de Identificacion:  </b><?php echo $medico->identificacion;?></h4>
        <h4 style="color: #000;"><b>Numero Tarjeta Profecional:  </b><?php echo $medico->numero_tarjeta;?></h4>
    </div>
    <?php echo $output; ?>
</section>