var wpcocontent = 1;
var request = false;

jQuery(document).ready(function() {
	jQuery("[id*=checkboxall]").click(function() {
		var status = this.checked;
		
		jQuery("[id*=checklist]").each(function() {
			this.checked = status;	
		});
	});
	
	jQuery("input[id*=checkinvert]").click(function() {
		this.checked = false;
	
		jQuery("input[id*=checklist]").each(function() {
			var status = this.checked;
			
			if (status == true) {
				this.checked = false;
			} else {
				this.checked = true;
			}
		});
	});
});

function wpco_featuredproduct(product_id, featured) {
	jQuery('#featured' + product_id + ' a.featured').toggleClass('loading');
	jQuery.post(wpcoajaxurl + "?action=wpcofeaturedproduct", {product_id:product_id, status:featured}, function(response) {
		jQuery('#featured' + product_id).html(response);
	});
}

function wpco_submitserial(form) {
	jQuery('#wpco_submitserial_loading').show();
	var formdata = jQuery(form).serialize();

	jQuery.post(wpcoajaxurl + '?action=wpcoserialkey', formdata, function(response) {
		jQuery('#wpcosubmitserial').html(response);
		jQuery.colorbox.resize();
	});
}

function wpco_deleteserial() {
	jQuery('#wpco_submitserial_loading').show();

	jQuery.post(wpcoajaxurl + '?action=wpcoserialkey&delete=1', false, function(response) {
		jQuery.colorbox.close(); parent.location.reload(1);
	});
}

function jqCheckForState(country, updatediv, inputname, showinput) {						
	var mytime = new Date().getTime();
	var country_id = jQuery(country).val();
	
	jQuery('#' + updatediv).html('loading...');
	
	jQuery.post(wpcoAjax + "?cmd=get_states_by_country&showinput=" + showinput + "&country_id=" + country_id + "&inputname=" + inputname + "&mytime=" + mytime, "", function(response) {
		if (response != "") {
			jQuery('#shipping-country-loading').hide();
			
			jQuery('#' + updatediv).html(response).hide().fadeIn();
		} else {
			jQuery('#' + updatediv).html('All States/Provinces').hide().fadeIn();	
		}
	});	
	
	return true;
}

function jqCheckAllByClass(checker, classname) {
	jQuery('input:checkbox[class="' + classname + '"]').each(function() {
		jQuery(this).attr("checked", checker.checked);
	});
}

function jqCheckAll(checker, formid, name) {					
	jQuery('input:checkbox[name="' + name + '[]"]').each(function() {
		jQuery(this).attr("checked", checker.checked);
	});
}

function wpco_scroll(selector) {
	if (jQuery(selector).length > 0) {
		var targetOffset = jQuery(selector).offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
	}
}

function wpco_category_add(product_id) {
	var mytime = new Date().getTime();
	jQuery('#category-add-loading').show();
	
	jQuery.post(wpcoAjax + "?cmd=category_add&product_id=" + product_id + "&mytime=" + mytime + "", {title:jQuery('#category_title').val(), parent:jQuery('#category_parent').val()}, function(response) {
		var success = jQuery(response).find('success').text();
		var html = jQuery("html", response).text();
		jQuery('#category-add-loading').hide();
		
		jQuery('#categories-div').html(html).hide().fadeIn();
	}, 'xml');
}

function wpco_category_delete(product_id, category_id) {
	var mytime = new Date().getTime();
	
	jQuery.post(wpcoAjax + "?cmd=category_delete&category_id=" + category_id + "&product_id=" + product_id + "&mytime=" + mytime + "", {id:category_id}, function(response) {
		var success = jQuery(response).find('success').text();
		var html = jQuery("html", response).text();
		jQuery('#categories-div').html(html).hide().fadeIn();
	}, 'xml');
}

function wpco_supplier_add() {
	var mytime = new Date().getTime();
	jQuery('#supplier-add-loading').show();
	
	jQuery.post(wpcoAjax + "?cmd=supplier_add&mytime=" + mytime, {name:jQuery('#supplier_name').val()}, function(response) {
			jQuery('#suppliers-div').hide().html(response).fadeIn();
			jQuery('#supplier-add-loading').hide();
			jQuery('#supplier-add').hide();
		});	
}

function wpcochangedisplay(number, value) {
	jQuery('#displayproducts' + number).hide();
	jQuery('#remoteproducts' + number).hide();
	jQuery('#displaycategories' + number).hide();
	jQuery('#displaycart' + number).hide();
	jQuery('#dropdown' + number).hide();
	
	if (value == "products" || value == "remoteproducts") {	
		jQuery('#displayproducts' + number).show();
		
		if (value == "remoteproducts") {
			jQuery('#remoteproducts' + number).show();
		}
	} else if (value == "cart") {
		jQuery ('#displaycart' + number).show();
	} else if (value == "categories") {
		jQuery('#displaycategories' + number).show();
	}
	
	if (value == "products" || value == "categories" || value == "suppliers") {
		jQuery('#dropdown' + number).show();	
	}
}

/* Dynamic Product Price Update */
function wpco_updateproductprice_new(productid, calcmessage) {	
	if (eval("request" + productid)) { eval("request" + productid + ".abort();"); }
	
	var mytime = new Date().getTime();
	var formValues = jQuery('#addtocart' + productid).serialize();
	jQuery('#productprice' + productid).html(calcmessage);
	var oldattr = jQuery('#submitbuttontext' + productid).attr('value');
	jQuery('#submit' + productid + ' input').button('option', 'disabled', true).attr('value', calcmessage);
	
	jQuery('input[name="wpcomethod"]').attr("name", "wpcomethodold");
	
	var request = jQuery.post(wpcoajaxurl + "action=updateproductprice&cmd=updateproductprice&mytime=" + mytime, formValues, function(response) {
		if (response != "") {
			if (jQuery('#productprice' + productid + ' .priceinside').length == 0) {
				jQuery('#productprice' + productid + '').html('<span class="priceinside">' + response + '</span>');	
			} else {
				jQuery('#productprice' + productid + ' .priceinside').html(response);
			}
			
			jQuery('#submit' + productid + ' input').button('option', 'disabled', false).attr('value', oldattr);
			jQuery('input[name="wpcomethodold"]').attr("name", "wpcomethod");
		}
	});
	
	eval("request" + productid + " = request;");	
	return false;
}

function wpco_updateproductprice(productid, calcmessage) {	
	if (request) { request.abort(); }

	if (wpcoDoAjax == false) {
		//return false;	
	}
	
	var mytime = new Date().getTime();
	var formValues = jQuery('#addtocart' + productid).serialize();
	jQuery('#productprice' + productid).html(calcmessage);
	//var oldattr = jQuery('#submit' + productid + ' input').attr('value');
	var oldattr = jQuery('#submitbuttontext' + productid).attr('value');
	jQuery('#submit' + productid + ' input').button('option', 'disabled', true).attr('value', calcmessage);
	
	jQuery('input[name="wpcomethod"]').attr("name", "wpcomethodold");
	
	request = jQuery.post(wpcoajaxurl + "action=updateproductprice&cmd=updateproductprice&mytime=" + mytime, formValues, function(response) {
		if (response != "") {
			if (jQuery('#productprice' + productid + ' .priceinside').length == 0) {
				jQuery('#productprice' + productid + '').html('<span class="priceinside">' + response + '</span>');	
			} else {
				jQuery('#productprice' + productid + ' .priceinside').html(response);
			}
			
			jQuery('#submit' + productid + ' input').button('option', 'disabled', false).attr('value', oldattr);
			jQuery('input[name="wpcomethodold"]').attr("name", "wpcomethod");
		}
	});
	
	return false;
}

function wpco_updateshipping() {
		
}

function wpco_refreshcartwidget() {
	
}

function wpco_cartsummary(summary, width) {
	jQuery(document).bind('cbox_complete', function() { 
		jQuery.colorbox.resize({width:width}); 
		jQuery('#cboxClose').remove(); 
	});
	
	jQuery.colorbox({html:summary, width:width});
	
}

/* Add to cart function */
function wpco_addtocart(form, productid, number, showloading) {		
	var formvalues = form.serialize();
	var mytime = new Date().getTime();
	jQuery('ul.wpcoerrors').remove();
	jQuery('#message' + productid).hide();
	var oldattr = jQuery('#submitbuttontext' + productid).attr('value');
	jQuery('#submit' + productid + ' input').button('option', 'disabled', true).attr('value', "Adding product...").removeClass('ui-state-hover');
	jQuery('#added' + productid).hide();
	jQuery('#widget-cart-errors').hide();
	jQuery('#wpcoloadingwrap' + productid).css('display', "inline");
	
	jQuery.post(wpcoAjax + "?cmd=add_to_cart&number=" + number + "&mytime=" + mytime + "", formvalues, function(data) {
		var success = jQuery(data).find('success').text();
		var message = jQuery("message", data).text();
		var html = jQuery("html", data).text();			
		var summary = jQuery("summary", data).text();
		var newmessage = message;
		
		if (summary.length != 0) {
			if (success == "Y") {
				wpco_cartsummary(summary, "640px");
			} else {
				wpco_cartsummary(summary, "auto");
			}
		} else {
			if (wpcoScrollAjax == true) {
				wpco_scroll(jQuery('#' + number).parent());		
			}
		}
		
		if (jQuery('div.widget-cart').length != 0) {
			jQuery('div.widget-cart').show().html(html);
		}
																												
		if (jQuery("#" + number).length != 0) {
			if (success == "Y") {
				jQuery("#" + number).show().html(html);
			} else {
				jQuery('#widget-cart-success').hide();
				jQuery("#widget-cart-errors").html(html).show();
			}
		}
		
		jQuery('#wpcoloadingwrap' + productid).hide();
		jQuery('#submit' + productid + ' input').button('option', 'disabled', false).attr('value', oldattr);
	}, 'xml');
}

function wpco_gencouponcode() {
	var mytime = new Date().getTime();
	jQuery("#couponcodeloading").show();
	jQuery('#couponcodelink a').attr('disabled', 'disabled');
	
	jQuery.post(wpcoAjax + "?cmd=gen_coupon_code&mytime=" + mytime, "", function(data) {
		jQuery("#couponcodecol").html(data);
		jQuery("#couponcodeloading").hide();
		jQuery('#couponcodelink a').removeAttr('disabled');
	});
}

function wpco_emptycart(number) {
	var mytime = new Date().getTime();
	wpco_scroll(jQuery("#" + number).parent());
	
	jQuery.post(wpcoajaxurl + 'action=emptycart&number=' + number + '&mytime=' + mytime, false, function(response) {	
		if (jQuery('div.widget-cart').length != 0) {
			jQuery('div.widget-cart').html(response);
		}
		
		if (jQuery('#' + number).length != 0) {
			jQuery("#" + number).html(response);
		}
	});
}

function wpco_favorite(product) {
	var mytime = new Date().getTime();
	var oldhtml = jQuery('#favoritesubmit' + product).html();
	jQuery('#favoritesubmit' + product).html('Adding to favorites...');

	jQuery.post(wpcoAjax + "?cmd=add_favorite&product=" + product + "&mytime=" + mytime, "", function(response) {
		jQuery('#favoritesubmit' + product).html(response).delay(2000).queue(function() {
			//jQuery('#favoritesubmit' + product).html(oldhtml);	
		});
	}); 
}

function wpco_deletefavorite(favorite_id) {
	var mytime = new Date().getTime();
	
	jQuery.post(wpcoAjax + "?cmd=delete_favorite&favorite_id=" + favorite_id + "&mytime=" + mytime, function(response) {
		jQuery('#favorites-div').hide().html(response).fadeIn();	
	});	
}

function wpcoConvertPostType(product_id, post_id, post_type) {
	jQuery('#convertposttopageloading').show();
	
	jQuery.post(wpcoajaxurl + '?action=convertposttype&product_id=' + product_id + '&post_id=' + post_id + '&post_type=' + post_type, function(response) {
		jQuery('#convertposttopageloading').hide();
		window.location.reload();
	});
}

function wpco_adminajax(caption, action) {
	jQuery.colorbox({href:wpcoajaxurl + '?action=' + action});
}