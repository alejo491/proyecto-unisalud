<!--content -->
<div class="body3">
	<div class="main">
		<?php $this->load->view($topcontent);?>
	</div>
</div>
<div class="main">
	<?php 
        if(isset($output)){
            $this->load->view($content,$output);
        }
        else{
            $this->load->view($content);
        }
?>
    <div id="mensaje">
        <?php 
            $session = $this->session->all_userdata();
            if(isset($session['mensaje']) && $session['mensaje']!=NULL && $session['mensaje']!=""):
        ?>
        <h4 style="background: none; color: #480091; border: none; margin: 0px; font-size: 20px;"><?php echo $session['mensaje'];?></h4>
        <?php endif;?>
    </div>
</div>
<!--content end-->