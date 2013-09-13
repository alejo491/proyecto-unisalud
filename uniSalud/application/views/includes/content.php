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
        }else{
            
            $this->load->view($content);
        }
        ?>
</div>
<!--content end-->