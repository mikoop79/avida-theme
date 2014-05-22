<!-- Global Custom Fields -->
<?php $wpcoDb -> model = $wpcoField -> model; ?>
<?php if ($fields = $wpcoDb -> find_all(array('globalf' => "Y", 'globalp' => $globalp), null, array('order', "ASC"))) : ?>
	<div class="<?php echo $this -> pre; ?>globalfields">
		<?php $this -> render('errors', array('errors' => $globalerrors), true, 'default'); ?>
	    <table class="<?php echo $this -> pre; ?>">
	        <tbody>
	            <?php foreach ($fields as $field) : ?>
	                <tr>
	                    <th><label for="<?php echo $field -> slug; ?>"><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?>: <?php if (!empty($field -> required) && $field -> required == "Y") : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
	                    <td>
	                        <?php 
	                    
	                        $wpcoDb -> model = $wpcoFieldsOrder -> model;
	                        if ($fieldorder = $wpcoDb -> find(array('field_id' => $field -> id, 'order_id' => $order_id))) {
	                            $_POST[$field -> slug] = $fieldorder -> value;
	                        } 
	                        
	                        ?>
	                        <?php $this -> render_field($field -> id, $fieldset = false, $fieldorder -> value, false, true); ?>
	                    </td>
	                </tr>
	            <?php endforeach; ?>
	        </tbody>
	    </table>
	</div>
<?php endif; ?>