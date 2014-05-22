<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Importing Products', $this -> plugin_name); ?></h2>
	
	<?php if (!empty($products)) : ?>		
		<p><span id="importajaxcount"><strong><span id="importajaxcountinside" style="color:green;">0</span></strong></span> <span id="importajaxfailedcount">(<strong><span id="importajaxfailedcountinside" style="color:red;">0</span></strong> failed)</span> <?php _e('out of', $this -> plugin_name); ?> <strong><?php echo count($products); ?></strong> <?php _e('products have been imported.', $this -> plugin_name); ?></p>
		
		<div id="importprogressbar"></div>
		
		<style type="text/css">
		.ui-progressbar-value {
			background-image: url('<?php echo $this -> url(); ?>/images/pbar-ani.gif') !important;
		}
		</style>
		
		<p class="submit">
			<a href="" onclick="cancelimporting(); return false;" id="cancelimporting" disabled="disabled" style="display:none;" class="button-secondary"><?php _e('Stop', $this -> plugin_name); ?></a>
			<a href="" onclick="startimporting(); return false;" id="startimporting" disabled="disabled" class="button-primary"><?php _e('Reading data, please wait', $this -> plugin_name); ?></a>
			<span id="importmore" style="display:none;"><a href="?page=<?php echo $this -> sections -> import_csv; ?>" id="" class="button-secondary"><?php _e('Import More', $this -> plugin_name); ?></a></span>
		</p>
		
		<div id="importtest"></div>
		
		<h3 style="display:none;"><?php _e('Products Imported', $this -> plugin_name); ?></h3>
		<div id="importajaxsuccessrecords" class="scroll-list" style="display:none;"><!-- successful records --></div>
		
		<h3 style="display:none;"><?php _e('Failed Products', $this -> plugin_name); ?></h3>
		<div id="importajaxfailedrecords" class="scroll-list" style="display:none;"><!-- failed records --></div>
		
		<div id="importajaxresponse"><!-- response here --></div>
		
		<div id="importajaxbox" style="display:none;"><?php
		
		$i = 1;		
		foreach ($products as $product) {
			echo htmlspecialchars(maybe_serialize($product));
			if ($i <= count($product)) { echo '<|>'; }
			$i++;
		}
		
		?></div>
		
		<script type="text/javascript">
		jQuery(document).ready(function() {		
			requestArray = new Array();
			cancelimport = "N";
			importingnumber = 1000;
			importoptions = '<?php echo addslashes(maybe_serialize($options)); ?>';
			jQuery('#startimporting').removeAttr('disabled').text('<?php echo addslashes(__("Start Importing", $this -> plugin_name)); ?>');
		});
		
		function cancelimporting() {
			cancelimport = "Y";
			jQuery('#cancelimporting').attr('disabled', 'disabled');
			jQuery('#startimporting').removeAttr('disabled').attr('onclick', 'resumeimporting(); return false;').text('<?php echo addslashes(__('Resume Importing', $this -> plugin_name)); ?>');
			
			for (var r = 0; r < requestArray.length; r++) {
				requestArray[r].abort();
			}
		}
		
		function startimporting() {
			jQuery('#cancelimporting').removeAttr('disabled').show();
			jQuery('#startimporting').attr('disabled', 'disabled').text('<?php echo addslashes(__('Importing Now', $this -> plugin_name)); ?>');
		
			text = jQuery('#importajaxbox').text();
			productcount = '<?php echo count($products); ?>';
			products = text.split('<|>');
			completed = 0;
			cancelimport = "N";
			requests = 0;
			imported = 0;
			failed = 0;
			
			if (productcount < importingnumber) {
				importingnumber = productcount;
			}
			
			jQuery('#importprogressbar').progressbar({value:0});
			
			for (i = 0; i < importingnumber; i++) {
				if (i < productcount) {
					importproduct(products[i]);
				}
			}
		}
		
		function resumeimporting() {
			cancelimport = "N";
			jQuery('#startimporting').attr('disabled', 'disabled').text('<?php echo addslashes(__('Importing Now', $this -> plugin_name)); ?>');
			jQuery('#cancelimporting').removeAttr('disabled');
			
			var newimportingnumber = (importingnumber - completed);
			requests = (completed - 1);
		
			for (i = 0; i < newimportingnumber; i++) {			
				if (i < productcount) {				
					importproduct(products[(completed + i)]);
				}
			}
		}
		
		function importproduct(product) {
			if (requests >= productcount || cancelimport == "Y") { return; }
		
			requests++;
		
			requestArray.push(jQuery.post(wpcoajaxurl + '?action=<?php echo $this -> pre; ?>importproducts', {product:product, importoptions:options}, function(response) {		
				var data = response.split('<|>');
				var success = data[0];
				var title = data[1];
				var message = data[2];
				
				jQuery('#importtest').append(response);
											
				if (success == "Y") {
					imported++;
					
					if ((imported + failed) <= productcount) {
						jQuery('#importajaxcountinside').text(imported);
						jQuery('#importajaxsuccessrecords').prepend(title + '<br/>').fadeIn().prev().fadeIn();
					}
				} else {
					failed++;
					
					if ((imported + failed) <= productcount) {
						jQuery('#importajaxfailedcountinside').text(failed);
						jQuery('#importajaxfailedrecords').prepend('<strong>' + title + '</strong>' + message + '<br/>').fadeIn().prev().fadeIn();
					}
				}
				
				completed++;
				var value = (completed * 100) / productcount;
				jQuery("#importprogressbar").progressbar("value", value);
			}).success(function() { 			
				if (completed == productcount) {
					jQuery('#cancelimporting').hide();
					warnMessage = null;
					jQuery('#startimporting').text('<?php echo addslashes(__('Continue to Products', $this -> plugin_name)); ?>').removeAttr('disabled').removeAttr('onclick').attr("href", "?page=<?php echo $this -> sections -> import_csv; ?>");
					jQuery('#importmore').show();
				} else {
					importproduct(products[(requests + 1)]); 
				}
			}));
		}
		</script>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No products are available for import, please try again.', $this -> plugin_name); ?></p>
		<p>
			<a href="javascript:history.go(-1);" class="button button-primary" onclick=""><?php _e('&laquo; Back', $this -> plugin_name); ?></a>
		</p>
	<?php endif; ?>
</div>

<script type="text/javascript">
var warnMessage = "<?php _e('You have unsaved changes on this page! All unsaved changes will be lost and it cannot be undone.', $this -> plugin_name); ?>";

jQuery(document).ready(function() {
    window.onbeforeunload = function () {
        if (warnMessage != null) return warnMessage;
    }
});
</script>