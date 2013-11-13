<!--content -->
<div class="body3">
	<div class="main">
		<?php $this->load->view($topcontent);?>
	</div>
</div>
<div class="main">
    <div id="mensaje">
        <?php 
            $session = $this->session->all_userdata();
            if(isset($session['mensaje']) && $session['mensaje']!=NULL && $session['mensaje']!=""):
        ?>
        <h4 style="background: none; color: #333333;  border:none; margin: 0px; font-size: 20px;">Ultima Accion: </h4>
        <h4 style="background: none; <?php if($session['exito']==TRUE): ?> color: #005702; <?php else: ?> color:#EE0000 <?php endif;?>  border: none; margin: 0px; font-size: 20px;"><?php echo $session['mensaje'];?></h4>
        <?php endif;?>
    </div>
	<?php 
        if(isset($output)){
            $this->load->view($content,$output);
        }
        else{
            $this->load->view($content);
        }
?>
</div>
<!--content end-->