<?php $this -> render('steps', array('step' => 'contacts', 'order' => $order), true, 'default'); ?>

<?php $ordersummarysections = $this -> get_option('ordersummarysections'); ?>
<?php if (!empty($ordersummarysections) && in_array('contacts', $ordersummarysections)) : ?>
	<?php $this -> render('cart-summary', array('order' => $order, 'items' => $items), true, 'default'); ?>
<?php endif; ?>

<div id="contacts-tabs">
	<ul>
    	<li><a href="<?php echo $wpcoHtml -> current_url(); ?>#contacts-tabs-1"><?php _e('New Customer', $this -> plugin_name); ?></a></li>
        <li><a href="<?php echo $wpcoHtml -> current_url(); ?>#contacts-tabs-2"><?php _e('Returning Customer', $this -> plugin_name); ?></a></li>
    </ul>
    
    <?php if (!empty($order)) : ?>
    	<?php $userstring = (!empty($order -> user)) ? '&userstring=' . $order -> user : ''; ?>
    <?php endif; ?>

    <div id="contacts-tabs-1">
        <h3><?php _e('New Customer', $this -> plugin_name); ?></h3>
        <div>
        	<form action="<?php echo $wpcoHtml -> retainquery("wpcomethod=contacts&amp;register=1" . $userstring, $_SERVER['REQUEST_URI']); ?>" method="post">
            	<?php if ((!empty($_GET['fromcart']) && $_GET['fromcart'] == 1) || (!empty($fromcart) && $fromcart == true)) : ?><input type="hidden" name="incheckout" value="1" /><?php endif; ?>
            
                <table class="wpco newcustomer">
                    <tbody>
                        <?php $class = ''; ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="<?php echo $this -> pre; ?>fname"><?php _e('First Name', $this -> plugin_name); ?></label></th>
                            <td>
                                <input type="text" name="fname" value="<?php echo esc_attr(stripslashes($_POST['fname'])); ?>" id="<?php echo $this -> pre; ?>fname" style="width:95%;" class="<?php echo $this -> pre; ?> widefat" />
                                <?php if (!empty($errors['fname'])) { $this -> render('error', array('error' => $errors['fname']), true, 'default'); }; ?>
                            </td>
                        </tr>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="<?php echo $this -> pre; ?>lname"><?php _e('Last Name', $this -> plugin_name); ?></label></th>
                            <td>
                                <input type="text" name="lname" value="<?php echo esc_attr(stripslashes($_POST['lname'])); ?>" id="<?php echo $this -> pre; ?>lname" style="width:95%;" class="<?php echo $this -> pre; ?> widefat" />
                                <?php if (!empty($errors['lname'])) { $this -> render('error', array('error' => $errors['lname']), true, 'default'); }; ?>
                            </td>
                        </tr>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="<?php echo $this -> pre; ?>email"><?php _e('Email Address', $this -> plugin_name); ?></label></th>
                            <td>
                                <input type="text" name="email" value="<?php echo esc_attr(stripslashes($_POST['email'])); ?>" id="<?php echo $this -> pre; ?>email" style="width:95%;" class="<?php echo $this -> pre; ?> widefat" />
                                <?php if (!empty($errors['email'])) { $this -> render('error', array('error' => $errors['email']), true, 'default'); }; ?>
                            </td>
                        </tr>
                        <?php if ($this -> get_option('usernamepreference') == "Y") : ?>
                        	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            	<th><label for="username"><?php _e('Username', $this -> plugin_name); ?></label></th>
                                <td>
                                	<input style="width:95%;" class="widefat" type="text" name="username" value="<?php echo esc_attr(stripslashes($_POST['username'])); ?>" id="username" />
                                    <?php if (!empty($errors['username'])) { $this -> render('error', array('error' => $errors['username']), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($this -> get_option('choosepassword') == "Y") : ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="password1"><?php _e('Password', $this -> plugin_name); ?></label></th>
                                <td>
                                    <input style="width:95%;" class="widefat" type="password" name="password1" value="<?php echo esc_attr(stripslashes($_POST['password1'])); ?>" autocomplete="off" id="password1" />
                                    <?php if (!empty($errors['password1'])) { $this -> render('error', array('error' => $errors['password1']), true, 'default'); }; ?>
                                </td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="password2"><?php _e('Retype Password', $this -> plugin_name); ?></label></th>
                                <td>
                                    <input style="width:95%;" class="widefat" type="password" name="password2" value="<?php echo esc_attr(stripslashes($_POST['password2'])); ?>" autocomplete="off" id="password2" />
                                    <?php if (!empty($errors['password2'])) { $this -> render('error', array('error' => $errors['password2']), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <?php do_action($this -> pre . '_contacts_before_register_button', $order -> id, $errors); ?>
                
                <?php $registercaptcha = $this -> get_option('registercaptcha'); ?>
                <?php if (!empty($registercaptcha) && $registercaptcha == "Y") : ?>
	                <?php 
	                
	                $registercaptcha_publickey = $this -> get_option('registercaptcha_publickey');
	                $registercaptcha_theme = $this -> get_option('registercaptcha_theme');
	                
	                ?>
	                
					<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
					
					<script type="text/javascript">
					jQuery(document).ready(function() {
						Recaptcha.create("<?php echo $registercaptcha_publickey; ?>", "registercaptcha", {
							theme: "<?php echo $registercaptcha_theme; ?>"
						});
					});
					</script>
					
					<div id="registercaptcha" class="recaptcha"></div>
					<?php if (!empty($errors['captcha'])) { $this -> render('error', array('error' => $errors['captcha']), true, 'default'); } ?>
				<?php endif; ?>
				
				<div style="display:none;">
                	<input type="text" name="namefield" value="" id="namefield" />
                </div>
                <?php if (!empty($errors['namefield'])) { $this -> render('error', array('error' => $errors['namefield']), true, 'default'); } ?>
				
				<?php if ($this -> get_option('choosepassword') == "N") : ?>		
                    <p>
                        <small><?php _e('A password will be emailed to you', $this -> plugin_name); ?></small>
                    </p>
                <?php endif; ?>
                
                <p>
                    <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
                    <input class="<?php echo $this -> pre; ?>button" type="submit" name="submit" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
                </p>
            </form>
        </div>
    </div>
    <div id="contacts-tabs-2">
    	<h3><?php _e('Returning Customer', $this -> plugin_name); ?></h3>
        <div>
        	<form action="<?php echo site_url('wp-login.php', 'login_post') ?>" method="post">
                <table class="wpco returncustomer">
                    <tbody>
                        <?php $class = ''; ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="username"><?php _e('Username/Email', $this -> plugin_name); ?></label></th>
                            <td>
                                <input class="<?php echo $this -> pre; ?> widefat" style="width:95%;" type="text" name="log" value="<?php echo esc_attr(stripslashes($_POST['username'])); ?>" id="username" />
                                <?php if (!empty($errors['username'])) { $this -> render('error', array('error' => $errors['username']), true, 'default'); }; ?>
                            </td>
                        </tr>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="password"><?php _e('Password', $this -> plugin_name); ?></label></th>
                            <td>
                                <input class="<?php echo $this -> pre; ?> widefat" style="width:95%;" type="password" name="pwd" value="<?php echo esc_attr(stripslashes($_POST['password'])); ?>" id="password" />
                                <?php if (!empty($errors['password'])) { $this -> render('error', array('error' => $errors['password']), true, 'default'); }; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <p>
                    <small><?php echo $wpcoHtml -> link(__('Forgotten Password?', $this -> plugin_name), site_url() . '/wp-login.php?action=lostpassword'); ?></small>
                </p>
                
                <?php do_action($this -> pre . '_contacts_before_login_button', $order -> id, $errors); ?>
                
                <p>
                	<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
                    <?php if (!empty($errors['login'])) { $this -> render('error', array('error' => $errors['login']), true, 'default'); }; ?>
                    <input class="<?php echo $this -> pre; ?>button" type="submit" name="submit" value="<?php _e('Log In &raquo;', $this -> plugin_name); ?>" />
                </p>
                
                <input type="hidden" name="rememberme" value="forever" />
                <?php $location = ($Order -> do_shipping($Order -> cart_order()) == true) ? $wpcoHtml -> ship_url() : $wpcoHtml -> bill_url(); ?>
                <?php $newlocation = (!empty($gotoaccount) && $gotoaccount == true) ? $wpcoHtml -> account_url() : $location; ?>
                <input type="hidden" name="redirect_to" value="<?php echo esc_attr($newlocation); ?>" />
                <input type="hidden" name="testcookie" value="1" />
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#wpcofname').focus();
	$contactstabs = jQuery('#contacts-tabs').tabs();								
});
</script>