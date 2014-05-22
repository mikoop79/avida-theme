<?php

error_reporting(0);
@ini_set('display_errors', 0);

global $wpdb, $wpcoDb, $Category, $Supplier;
$root = __FILE__;
for ($i = 0; $i < 6; $i++) $root = dirname($root);
if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
require_once($root . DS . 'wp-config.php');
require_once(ABSPATH . 'wp-admin' . DS . 'includes' . DS . 'admin.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php _e('Shopping Cart functions', "wp-checkout"); ?></title>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript">
	
	var _self = tinyMCEPopup;
	function init () {
		//changeCategory();
		tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertTag () {		
		var tag = "";
		var products_panel = document.getElementById('products_panel');
		var categories_panel = document.getElementById('categories_panel');
		var suppliers_panel = document.getElementById('suppliers_panel');
		var cart_panel = document.getElementById('cart_panel');
	
		if (products_panel.className.indexOf('current') != -1) {
			var categoryid = jQuery('#wpco-category-menu').val();
			var suborder = jQuery('#suborder').val();
			var suborderby = jQuery('#suborderby').val();
			var tag = '[wpcocategory id="' + categoryid + '" suborder="' + suborder + '" suborderby="' + suborderby + '"]';
	
			var productid = jQuery('#wpco-product-menu').val();
			if (productid != 0 && productid != "" && productid != null) { 
				tag = '[wpcoproduct id="' + productid + '"]'; 
			}
		}
		
		if (categories_panel.className.indexOf('current') != -1) {
			var categories_type = jQuery('input[name=categories_type]:checked').val();
			var tag = '[wpcocategories type="' + categories_type + '"]';
		}
		
		if (suppliers_panel.className.indexOf('current') != -1) {
			var suppliers_display = jQuery('input[name="suppliers_display"]:checked').val();
			
			if (suppliers_display == "single") {
				var supplier_id = jQuery('#supplier_id').val();
				var tag = '[wpcosupplier id="' + supplier_id + '"]';
			} else {
				var suppliers_order = jQuery('#suppliers_order').val();
				var suppliers_orderby = jQuery('#suppliers_orderby').val();
				var tag = '[wpcosuppliers order="' + suppliers_order + '" orderby="' + suppliers_orderby + '"]';	
			}
		}
		
		if (cart_panel.className.indexOf('current') != -1) {
			var tag = '[wpcocart]';
		}
		
		if(window.tinyMCE && tag != "") {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tag);
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	
	function closePopup () {
		tinyMCEPopup.close();
	}

	function changeCategory () {
		var menu = jQuery('#wpco-category-menu');
		var products = jQuery('#wpco-product-menu');
		jQuery('#category_message').show();
				
		jQuery.post("<?php echo WP_PLUGIN_URL; ?>/wp-checkout/wp-checkout-ajax.php?cmd=products_by_cat&cat_id=" + menu.val(), {category:menu.val()}, function(response) {			
			jQuery('#wpco-product-menu').html(response);
			jQuery('#category_message').hide();
		});
	}
		
	</script>
	
	<style type="text/css">
		table th { vertical-align: top; }
		.panel_wrapper { border-top: none !important; }
		.panel_wrapper div.current { height:auto !important; }
		#product-menu { width: 180px; }
		label { cursor:pointer; }
	</style>
	
</head>
<body onload="init();">

<div id="wpwrap">
    <form onsubmit="insertTag(); return false;" action="#">
        <div class="tabs">
            <ul>
                <li id="products_tab" class="current"><span><a href="javascript:mcTabs.displayTab('products_tab','products_panel');" onmousedown="return false;"><?php _e('Category/Product', "wp-checkout"); ?></a></span></li>
                <li id="categories_tab"><span><a href="javascript:mcTabs.displayTab('categories_tab','categories_panel');" onmousedown="return false;"><?php _e('Categories', "wp-checkout"); ?></a></span></li>
                <li id="suppliers_tab"><span><a href="javascript:mcTabs.displayTab('suppliers_tab','suppliers_panel');" onmousedown="return false;"><?php _e('Suppliers', "wp-checkout"); ?></a></span></li>
                <li id="cart_tab"><span><a href="javascript:mcTabs.displayTab('cart_tab','cart_panel');" onmousedown="return false;"><?php _e('Shopping Cart', "wp-checkout"); ?></a></span></li>
            </ul>
        </div>
    
        <div class="panel_wrapper">
        	<div id="products_panel" class="panel current">
            	<br/>
                <table border="0" cellpadding="4" cellspacing="0">
                    <tbody>
                        <tr>
                            <th nowrap="nowrap"><label for="wpco-category-menu"><?php _e("Category", 'wp-checkout'); ?></label></th>
                            <td>
                                <select id="wpco-category-menu" name="category" onchange="changeCategory();">
                                    <option value=""><?php _e('- Select Category -', 'wp-checkout'); ?></option>
                                    <?php if ($categories = $Category -> select()) : ?>
                                        <?php foreach ($categories as $cat_id => $cat_title) : ?>
                                            <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span id="category_message" style="display:none;"><?php _e('loading...', "wp-mailinglist"); ?></span>
                            </td>
                        </tr>
                        <tr id="product-selector">
                            <th nowrap="nowrap"><label for="wpco-product-menu"><?php _e("Product", 'wp-checkout'); ?></label></th>
                            <td><select id="wpco-product-menu" name="product" style="width:210px;" size="7"></select></td>
                        </tr>
                        <tr>
                        	<th nowrap="nowrap"><label for="suborder"><?php _e('Sub Categories Order', "wp-checkout"); ?></label></th>
                            <td>
                            	<select name="suborder" id="suborder">
                                	<option value="ASC"><?php _e('Ascending', "wp-checkout"); ?></option>
                                    <option value="DESC"><?php _e('Descending', "wp-checkout"); ?></option>
                                </select>
                                <?php _e('BY', "wp-checkout"); ?>
                                <select name="suborderby" id="suborderby">
                                	<option value="id"><?php _e('ID', "wp-checkout"); ?></option>
                                    <option value="title"><?php _e('Title', "wp-checkout"); ?></option>
                                    <option value="created"><?php _e('Created Date', "wp-checkout"); ?></option>
                                    <option value="modified"><?php _e('Modified Date', "wp-checkout"); ?></option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="categories_panel" class="panel">
            	<br/>
                <table border="0" cellpadding="4" cellspacing="0">
                	<tbody>
                    	<tr>
                        	<th><label for="categories_type_list"><?php _e('Categories Type', "wp-checkout"); ?></label></th>
                            <td>
                            	<label><input checked="checked" type="radio" name="categories_type" value="list" id="categories_type_list" /> <?php _e('List View', "wp-checkout"); ?></label>
                                <label><input type="radio" name="categories_type" value="grid" id="categories_type_grid" /> <?php _e('Grid View', "wp-checkout"); ?></label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="suppliers_panel" class="panel">
            	<br/>
                <table border="0" cellpadding="4" cellspacing="0">
                	<tbody>
                    	<tr>
                        	<th><label for="suppliers_display_all"><?php _e('Display', "wp-checkout"); ?></label></th>
                            <td>
                            	<label><input onclick="jQuery('#suppliers_display_all_div').hide(); jQuery('#suppliers_display_single_div').show();" type="radio" name="suppliers_display" value="single" id="suppliers_display_single" /> <?php _e('Single Supplier', "wp-checkout"); ?></label>
                                <label><input onclick="jQuery('#suppliers_display_all_div').show(); jQuery('#suppliers_display_single_div').hide();" checked="checked" type="radio" name="suppliers_display" value="all" id="suppliers_display_all" /> <?php _e('All Suppliers', "wp-checkout"); ?></label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div id="suppliers_display_all_div" style="display:block;">
                	<table border="0" cellpadding="4" cellspacing="0">
                    	<tbody>
                        	<tr>
                            	<th><label for="suppliers_order"><?php _e('Suppliers Order', "wp-checkout"); ?></label></th>
                                <td>
                                	<select name="suppliers_order" id="suppliers_order">
                                    	<option value="ASC"><?php _e('Ascending', "wp-checkout"); ?></option>
                                        <option value="DESC"><?php _e('Descending', "wp-checkout"); ?></option>
                                    </select>
                                    <?php _e('BY', "wp-checkout"); ?>
                                    <select name="suppliers_orderby" id="suppliers_orderby">
                                    	<option value="id"><?php _e('ID', "wp-checkout"); ?></option>
                                        <option value="name"><?php _e('Title/Name', "wp-checkout"); ?></option>
                                        <option value="created"><?php _e('Created Date', "wp-checkout"); ?></option>
                                        <option value="modified"><?php _e('Modified Date', "wp-checkout"); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div id="suppliers_display_single_div" style="display:none;">
                	<table border="0" cellpadding="4" cellspacing="0">
                    	<tbody>
                        	<tr>
                            	<th><label for="supplier_id"><?php _e('Choose Supplier', "wp-checkout"); ?></label></th>
                                <td>
                                	<?php if ($suppliers = $Supplier -> select()) : ?>
                                    	<select name="supplier_id" id="supplier_id">
                                        	<?php foreach ($suppliers as $skey => $sval) : ?>
                                            	<option value="<?php echo $skey; ?>"><?php echo $sval; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else : ?>
                                    	<?php _e('No suppliers are available.', "wp-checkout"); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="cart_panel" class="panel">
            	<p><?php _e('Insert a functional shopping cart.', "wp-checkout"); ?></p>
				<p><?php _e('Remember to set your Shopping Cart Page under Checkout > Configuration in order for this page to be used.', "wp-checkout"); ?></p>
            </div>
        </div>
        
        <div class="mceActionPanel">
            <div style="float: left">
                <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="closePopup()"/>
            </div>
    
            <div style="float: right">
                <input type="button" id="insert" name="insert" value="{#insert}" onclick="insertTag()" />
            </div>
        </div>
    </form>
</div>

</body>
</html>