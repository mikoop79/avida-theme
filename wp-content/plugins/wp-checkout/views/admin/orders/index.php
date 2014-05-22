<div class="wrap">
	<h2><?php _e('Manage Orders', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), $this -> url . '&amp;method=save', array('class' => "button add-new-h2")); ?></h2>
	
    <form id="posts-filter" action="<?php echo $wpcoHtml -> current_url(); ?>" method="post">
        <?php if (!empty($orders)) : ?>
            <ul class="subsubsub">
                <li><?php echo $paginate -> allcount; ?> <?php _e('orders', $this -> plugin_name); ?> |</li>
                <li><?php echo $wpcoHtml -> link(__('All Order Items', $this -> plugin_name), '?page=' . $this -> sections -> items); ?></li>
            </ul>
        <?php endif; ?>
        <p class="search-box">
            <input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
            <input type="submit" name="search" value="<?php _e('Search Orders', $this -> plugin_name); ?>" class="button" />
        </p>
    </form>		
    <br class="clear" />	
    <form id="posts-filter" action="?page=<?php echo $this -> sections -> orders; ?>" method="get">
    	<input type="hidden" name="page" value="<?php echo $this -> sections -> orders; ?>" />
    	
    	<?php if (!empty($_GET[$this -> pre . 'searchterm'])) : ?>
    		<input type="hidden" name="<?php echo $this -> pre; ?>searchterm" value="<?php echo esc_attr(stripslashes($_GET[$this -> pre . 'searchterm'])); ?>" />
    	<?php endif; ?>
    	
	    <div class="alignleft actions">
	    	<?php _e('Show', $this -> plugin_name); ?>	
	        <select style="max-width:200px;" name="completed" onchange="filter_value('completed', jQuery(this).val());">		
	            <option <?php echo (!empty($filters['completed']) && $filters['completed'] == "all") ? 'selected="selected"' : ''; ?> value="all"><?php _e('All Status', $this -> plugin_name); ?> </option>
	            <option value="Y" <?php if(empty($filters['completed']) || (!empty($filters['completed']) && $filters['completed']=='Y')){ echo 'selected="selected"'; }; ?>><?php _e('Completed', $this -> plugin_name); ?> </option>
	            <option value="N" <?php if(!empty($filters['completed']) && $filters['completed']=='N'){ echo 'selected="selected"'; }?>><?php _e('Not Completed', $this -> plugin_name); ?></option>
	        </select>
	
	        <?php $paymentmethods = get_option('wpcopaymentmethods'); ?>
	        <select style="max-width:200px;" name="pmethod" onchange="filter_value('pmethod', jQuery(this).val());">
	            <option value=""><?php _e('All Payment Methods', $this -> plugin_name); ?></option>
				<?php
					foreach($paymentmethods as $v) {
						if ($filters['pmethod'] == $v) { 
							echo '<option value="' . $v . '" selected>'.$wpcoHtml -> pmethod($v).'</option>';
						} else {
							echo '<option value="' . $v . '">'.$wpcoHtml -> pmethod($v).'</option>';
						}
					}
				?>
	        </select>
	
	        <?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
	        <?php $shipmethods = $wpcoDb -> find_all(); ?>	
	        <select style="max-width:200px;" name="shipmethod_id" onchange="filter_value('shipmethod_id', jQuery(this).val());">
				<option value=""><?php _e('All Shipping Methods', $this -> plugin_name); ?></option>
				<?php
					foreach ($shipmethods as $shipmethod) {
						if ($filters['shipmethod_id'] == $shipmethod -> id) { 
							echo '<option value="' . $shipmethod -> id . '" selected>'.$shipmethod -> name.'</option>';
						} else {
							echo '<option value="' . $shipmethod -> id . '">'.$shipmethod -> name.'</option>';
						}
					}
				?>
	        </select>								
	    </div>
	    <br class="clear" />
	    <div>
	    	<?php _e('Date range from', $this -> plugin_name); ?> <input type="text" name="fromdate" id="fromdate" value="<?php echo $_GET['fromdate']; ?>" /> <?php _e('to', $this -> plugin_name); ?> <input type="text" name="todate" id="todate" value="<?php echo $_GET['todate']; ?>" />
	    	<input class="button button-primary" type="submit" name="filter" value="<?php _e('Filter Orders', $this -> plugin_name); ?>" />
	    </div>
    </form>
            
    <br class="clear" />
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#fromdate').datepicker();
		jQuery('#todate').datepicker();
		<?php if (!isset($_COOKIE[$this -> pre . 'filter_completed'])) : ?>document.cookie = "<?php echo $this -> pre; ?>filter_completed=Y; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";<?php endif; ?>	
	});
	
    function filter_value(filtername, filtervalue) {			
        if (filtername != "") {
            document.cookie = "<?php echo $this -> pre; ?>filter_" + filtername + "=" + filtervalue + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
        }
    }
    </script>


	<?php $this -> render('orders' . DS . 'loop', array('orders' => $orders, 'paginate' => $paginate), true, 'admin'); ?>
</div>