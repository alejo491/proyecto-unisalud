<section id="content">
    <div><br/>
        <h2 id="titulo"><b>Informacion Personal:</b></h2>
        <h3 id="titulo"><b>Nombre:  </b><?php echo $medico->nombre_medico;?></h1>
        <h3 id="titulo"><b>Numero de Identificacion:  </b><?php echo $medico->identificacion;?></h2>
        <h3 id="titulo"><b>Numero Tarjeta Profecional:  </b><?php echo $medico->numero_tarjeta;?></h2>
        <h3 id="titulo"><b>Especialidad:  </b><?php echo $medico->especialidad;?></h2>
    </div>
    <?php echo $output; ?>
</section>