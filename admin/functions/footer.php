 <!-- Jquery Core Js -->
   <script src="<?php echo base_url_doc; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url_doc; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo base_url_doc; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url_doc; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="<?php echo base_url_doc; ?>plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url_doc; ?>plugins/node-waves/waves.js"></script>
 <script src="<?php echo base_url_doc; ?>plugins/jquery-steps/jquery.steps.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>  <script src="<?php echo base_url_doc; ?>plugins/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script src=".<?php echo base_url_doc; ?>js/pages/charts/morris.js"></script>
    <script src="<?php echo base_url_doc; ?>plugins/morrisjs/morris.js"></script>
    <!-- Custom Js -->
    <script src="<?php echo base_url_doc; ?>js/admin.js"></script>
    <script src="<?php echo base_url_doc; ?>js/pages/tables/jquery-datatable.js"></script>
<script src="<?php echo base_url_doc; ?>js/pages/forms/form-validation.js"></script>
    <!-- Demo Js -->
    <script src="<?php echo base_url_doc; ?>js/demo.js"></script>
    <?php
    ob_end_flush();
     ?>
      <script>
  $(function(){
  	$("#refer").click(function(){
		
	
               $.ajax({
                type: "POST",
  			     url:"<?php echo base_url_doc.'refer_ajax/' ?>",
        		data: $('#').serialize(),
        		success: function(data) {
        			if(data){
						$("#all_tab").html(data);
							}
							
               	}
               	})
                })
      }) 
</script>
 <script>
  $(function(){
  	$(".pre").click(function(){
		var id=$(this).data("id");
			$("#pre_data").val(id);
	
               $.ajax({
                type: "POST",
  			     url:"<?php echo base_url_doc.'prescription_ajax/' ?>",
        		data: $('#prescrip').serialize(),
        		success: function(data) {
        			if(data){
						$("#prescription").html(data);
							}
               	}
               	})
                }) })
</script>
<script>
  $(function(){
  	$(".tre").click(function(){
		var id=$(this).data("id");
			$("#tre_data").val(id);
	
               $.ajax({
                type: "POST",
  			     url:"<?php echo base_url_doc.'treatment_ajax/' ?>",
        		data: $('#treat').serialize(),
        		success: function(data) {
        			if(data){
						$("#treatment").html(data);
							}
               	}
               	})
                }) })
</script>
<script>
  $(function(){
  	$(".exp").click(function(){
		var id=$(this).data("id");
			$("#exp_data").val(id);
	
               $.ajax({
                type: "POST",
  			     url:"<?php echo base_url_doc.'expenses_ajax/' ?>",
        		data: $('#expenses_form').serialize(),
        		success: function(data) {
        			if(data){
						$("#expenses").html(data);
							}
               	}
               	})
                }) })
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_2').on('click', function(event) {        
             jQuery('#forhide').toggle('show');
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_23').on('click', function(event) {        
             jQuery('#forhide3').toggle('show');
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_24').on('click', function(event) {        
             jQuery('#forhide4').toggle('show');
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_8').on('click', function(event) {        
             jQuery('#forhide1').toggle('show');
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_13').on('click', function(event) {        
             jQuery('#forhide2').toggle('show');
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_1').on('click', function(event) {  
        if(document.getElementById('md_checkbox_1').checked)   
        {
			jQuery('#patient_name').toggle('show');
		} 
		else
		{
			jQuery('#patient_name').toggle('hide');
		}  
              
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_6').on('click', function(event) {   
              if(document.getElementById('md_checkbox_6').checked)   
              {
			jQuery('#clinic').toggle('show');
		     } 
		   else
		      {
			jQuery('#clinic').toggle('hide');
		     }  
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_7').on('click', function(event) { 
         if(document.getElementById('md_checkbox_7').checked)   
              {
			jQuery('#category').toggle('show');
		     } 
		   else
		      {
			jQuery('#category').toggle('hide');
		     }         
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_4').on('click', function(event) {    
         if(document.getElementById('md_checkbox_4').checked)   
              {
			jQuery('#contact').toggle('show');
		     } 
		   else
		      {
			jQuery('#contact').toggle('hide');
		     }      
             
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_9').on('click', function(event) { 
        if(document.getElementById('md_checkbox_9').checked)   
              {
			jQuery('#patien_name_cancel').toggle('show');
		     } 
		   else
		      {
			jQuery('#patien_name_cancel').toggle('hide');
		     }         
             
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_10').on('click', function(event) {  
        
        if(document.getElementById('md_checkbox_10').checked)   
        {
			jQuery('#clinic_cancel').toggle('show');
		} 
		else
		{
			jQuery('#clinic_cancel').toggle('hide');
		}  
             
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_11').on('click', function(event) {  
         if(document.getElementById('md_checkbox_11').checked)   
              {
			jQuery('#category_cancel').toggle('show');
		     } 
		   else
		      {
			jQuery('#category_cancel').toggle('hide');
		     }         
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_12').on('click', function(event) { 
        if(document.getElementById('md_checkbox_12').checked)   
              {
			jQuery('#contact_cancel').toggle('show');
		     } 
		   else
		      {
			jQuery('#contact_cancel').toggle('hide');
		     }           
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_14').on('click', function(event) {  
         if(document.getElementById('md_checkbox_14').checked)   
              {
			jQuery('#patien_name_reminder').toggle('show');
		     } 
		   else
		      {
			jQuery('#patien_name_reminder').toggle('hide');
		     }         
             
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_15').on('click', function(event) {  
         if(document.getElementById('md_checkbox_15').checked)   
              {
			jQuery('#clinic_reminder').toggle('show');
		     } 
		   else
		      {
			jQuery('#clinic_reminder').toggle('hide');
		     }         
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
        jQuery('#md_checkbox_16').on('click', function(event) {  
         if(document.getElementById('md_checkbox_16').checked)   
              {
			jQuery('#category_reminder').toggle('show');
		     } 
		   else
		      {
			jQuery('#category_reminder').toggle('hide');
		     }         
             
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
  	
        jQuery('#md_checkbox_17').on('click', function(event) {  
        
        if(document.getElementById('md_checkbox_17').checked)   
              {
			jQuery('#contact_reminder').toggle('show');
		     } 
		   else
		      {
			jQuery('#contact_reminder').hide();
		     }      
            
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
   if(document.getElementById('md_checkbox_1').checked)   
        {
        	
			jQuery('#patient_name').show();
		} 
		else
		{
			jQuery('#patient_name').toggle('hide');
		}  
		 if(document.getElementById('md_checkbox_6').checked)   
             {
			jQuery('#clinic').show();
		     } 
		   else
		      {
			jQuery('#clinic').toggle('hide');
		     }  
  	  if(document.getElementById('md_checkbox_7').checked)   
              {
			jQuery('#category').show();
		     } 
		   else
		      {
			jQuery('#category').toggle('hide');
		     }         
             if(document.getElementById('md_checkbox_4').checked)   
              {
			jQuery('#contact').show();
		     } 
		   else
		      {
			jQuery('#contact').toggle('hide');
		     }  
		      if(document.getElementById('md_checkbox_9').checked)   
              {
			jQuery('#patien_name_cancel').show();
		     } 
		   else
		      {
			jQuery('#patien_name_cancel').toggle('hide');
		     }  
		      if(document.getElementById('md_checkbox_10').checked)   
              {
			jQuery('#clinic_cancel').show();
		    } 
		else
		{
			jQuery('#clinic_cancel').toggle('hide');
		} 
		if(document.getElementById('md_checkbox_11').checked)   
              {
			jQuery('#category_cancel').show();
		     } 
		   else
		      {
			jQuery('#category_cancel').toggle('hide');
		     }   
		      if(document.getElementById('md_checkbox_12').checked)   
              {
			jQuery('#contact_cancel').show();
		     } 
		   else
		      {
			jQuery('#contact_cancel').toggle('hide');
		     }  
		     if(document.getElementById('md_checkbox_14').checked)   
              {
			jQuery('#patien_name_reminder').show();
		     } 
		   else
		      {
			jQuery('#patien_name_reminder').toggle('hide');
		     }  
		     if(document.getElementById('md_checkbox_15').checked)   
              {
			jQuery('#clinic_reminder').show();
		     } 
		   else
		      {
			jQuery('#clinic_reminder').toggle('hide');
		     }  
		     if(document.getElementById('md_checkbox_16').checked)   
              {
			jQuery('#category_reminder').show();
		     } 
		   else
		      {
			jQuery('#category_reminder').toggle('hide');
		     }
		     if(document.getElementById('md_checkbox_17').checked)   
              {
			jQuery('#contact_reminder').show();
		     } 
		   else
		      {
			jQuery('#contact_reminder').hide();
		     }    
		       
		     if(document.getElementById('md_checkbox_23').checked)   
              {
			jQuery('#forhide3').show();
		     } 
		   else
		      {
			jQuery('#forhide3').hide();
		     }  
		     if(document.getElementById('md_checkbox_13').checked)   
              {
			jQuery('#forhide2').show();
		     } 
		   else
		      {
			jQuery('#forhide2').hide();
		     }  
		        if(document.getElementById('md_checkbox_8').checked)   
              {
			jQuery('#forhide1').show();
		     } 
		   else
		      {
			jQuery('#forhide1').hide();
		     }
		      if(document.getElementById('md_checkbox_2').checked)   
              {
			jQuery('#forhide').show();
		     } 
		   else
		      {
			jQuery('#forhide').hide();
		     }          
    });
</script>