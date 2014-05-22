<p><?php _e('Logged in customers/users can easily add favorite products to their account with a single click from the category pages or individual product pages using Ajax technology.', $this -> plugin_name); ?>
<?php _e('Customers can easily access favorites from their account page at a later stage to re-visit those products.', $this -> plugin_name); ?></p>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="enablefavoritesY"><?php _e('Favorite Products', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('enablefavorites') == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#enablefavorites-div').show();" type="radio" name="enablefavorites" value="Y" id="enablefavoritesY" /> <?php _e('On', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('enablefavorites') == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#enablefavorites-div').hide();" type="radio" name="enablefavorites" value="N" id="enablefavoritesN" /> <?php _e('Off', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('turn this On to allow users to add favorite products to their account', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<div id="enablefavorites-div" style="display:<?php echo ($this -> get_option('enablefavorites') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
        	<tr>
            	<th><label for="favoritesshow_products"><?php _e('Where to show?', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input <?php echo ($this -> get_option('favoritesshow') == "products") ? 'checked="checked"' : ''; ?> type="radio" name="favoritesshow" value="products" id="favoritesshow_products" /> <?php _e('Product Pages', $this -> plugin_name); ?></label>
                    <label><input <?php echo ($this -> get_option('favoritesshow') == "productsandloop") ? 'checked="checked"' : ''; ?> type="radio" name="favoritesshow" value="productsandloop" id="favoritesshow_productsandloop" /> <?php _e('Product Pages and Loop', $this -> plugin_name); ?></label>
                	<span class="howto"><?php _e('specify where the Add to Favorites link should be shown in the shop', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>