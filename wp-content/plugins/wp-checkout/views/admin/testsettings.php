<script type="text/javascript">
var wpcoajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<div style="width:400px;">
    <h3><?php _e('Test Email Settings', $this -> plugin_name); ?></h3>
    
    <p><?php _e('This function will test your current email settings and provide an explanatory error message if email sending fails.', $this -> plugin_name); ?>
     <?php _e('Please type an email address below to send a test email to.', $this -> plugin_name); ?></p>
    
    <div style="color:red;"><?php $this -> render('errors', array('errors' => $errors), true, 'admin'); ?></div>
    
    <form id="testsettingsform" onsubmit="wpco_testsettings(this); return false;" action="<?php echo home_url(); ?>/?<?php echo $this -> pre; ?>method=testsettings" method="post">
    	<input type="hidden" name="submitform" value="1" />
    
        <p>
            <label for="testemail"><?php _e('Email Address', $this -> plugin_name); ?></label><br/>
            <input type="text" style="width:390px;" name="testemail" id="testemail" value="<?php echo esc_attr(stripslashes($_POST['testemail'])); ?>" />
        </p>
        
        <p>
        	<input class="button-secondary" onclick="jQuery.colorbox.close();" type="button" name="close" value="<?php _e('Close', $this -> plugin_name); ?>" />
            <input class="button-primary" type="submit" name="submit" value="<?php _e('Send Test Email', $this -> plugin_name); ?>" />
            <span style="display:none;" id="wpco_testsettings_loading"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /></span>
        </p>
    </form>
    
    <script type="text/javascript">
	function wpco_testsettings(form) {
		var formvalues = jQuery('#testsettingsform').serialize();
		jQuery('#wpco_testsettings_loading').show();
		
		jQuery.post(wpcoajaxurl + '?action=<?php echo $this -> pre; ?>testsettings', formvalues, function(response) {
			jQuery('#testsettingswrapper').html(response);
			jQuery('#wpco_testsettings_loading').hide();
			jQuery.colorbox.resize();
		});
	}
	</script>
</div>