<nav>
    <ul id="menu" style="float:left; padding-left: 2%;">
        <li id="menu_active"><?php echo anchor(base_url(), 'Inicio'); ?></li>
        <li id="menu_active"><?php echo anchor('personalSaludControlador/index', 'Personal Medico'); ?></li>
        <li id="menu_active"><?php echo anchor('programaSaludControlador/index', 'Programa de Salud'); ?></li>
        <!--<li id="menu_active"> <?php echo anchor('consultorioControlador/index', 'Consultorios'); ?></li> -->
        <li id="menu_active"><?php echo anchor('estandarControlador/index', 'Acerca de'); ?></li>
        
    </ul>
</nav>