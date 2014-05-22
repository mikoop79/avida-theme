<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Manage Extensions', $this -> plugin_name); ?></h2>        
    <?php $this -> render('extensions' . DS . 'navigation', false, true, 'admin'); ?>
    <p><?php _e('These are extensions which extend the functionality of the Shopping Cart plugin.', $this -> plugin_name); ?></p>
    
    <?php if (!empty($this -> extensions)) : ?>
    	<table class="widefat">
        	<thead>
            	<tr>
                	<th colspan="2"><?php _e('Extension Name', $this -> plugin_name); ?></th>
                    <th><?php _e('Extension Status', $this -> plugin_name); ?></th>
                </tr>
            </thead>
            <tfoot>
            	<tr>
                	<th colspan="2"><?php _e('Extension Name', $this -> plugin_name); ?></th>
                    <th><?php _e('Extension Status', $this -> plugin_name); ?></th>
                </tr>
            </tfoot>
        	<tbody>
            	<?php $class = ''; ?>
            	<?php foreach ($this -> extensions as $extension) : ?>                
                	<?php
					
					if ($this -> is_plugin_active($extension['slug'], false)) {
						$status = 2;	
					} elseif ($this -> is_plugin_active($extension['slug'], true)) {
						$status = 1;
					} else {
						$status = 0;
					}
					
					$context = 'all';
					$s = '';
					$page = 1;
					$path = $extension['plugin_name'] . DS . $extension['plugin_file'];
					$img = (empty($extension['image'])) ? $this -> url() . '/images/extensions/' . $extension['slug'] . '.png' : $extension['image'];
					
					?>
                
                	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
                		<th>
                			<a title="<?php echo esc_attr($extension['name']); ?>" onclick="jQuery.colorbox({title:'<?php echo $extension['name']; ?>', iframe:true, width:'80%', height:'80%', href:'<?php echo $extension['link']; ?>'}); return false;" href="<?php echo $extension['link']; ?>" style="border:none;">
                				<img class="extensionicon" src="<?php echo $img; ?>" border="0" style="border:none; width:75px; height:75px;" alt="<?php echo $extension['slug']; ?>" />
                			</a>
                		</th>
                    	<th>
							<a title="<?php echo esc_attr($extension['name']); ?>" onclick="jQuery.colorbox({title:'<?php echo $extension['name']; ?>', iframe:true, width:'80%', height:'80%', href:'<?php echo $extension['link']; ?>'}); return false;" href="<?php echo $extension['link']; ?>" class="row-title"><?php echo $extension['name']; ?></a>
							<br/><small class="howto"><?php echo $extension['description']; ?></small>
                            <div class="row-actions">
                            	<?php 
								
								switch ($status) {
									case 0	:
										?>
                                        
                                        <span class="edit"><a onclick="jQuery.colorbox({title:'<?php echo $extension['name']; ?>', iframe:true, width:'80%', height:'80%', href:'<?php echo $extension['link']; ?>'}); return false;" href="<?php echo $extension['link']; ?>" target="_blank"><?php _e('Get this extension now', $this -> plugin_name); ?></a></span>
                                        
                                        <?php
										break;
									case 1	:
										?>
                                        
                                        <span class="edit"><?php echo $wpcoHtml -> link(__('Activate', $this -> plugin_name), wp_nonce_url('?page=' . $this -> sections -> extensions . '&method=activate&plugin=' . plugin_basename($path))); ?></span>
                                        
                                        <?php
										break;
									case 2	:
										?>
                                        
                                        <span class="delete"><?php echo $wpcoHtml -> link(__('Deactivate', $this -> plugin_name), wp_nonce_url('?page=' . $this -> sections -> extensions . '&method=deactivate&plugin=' . plugin_basename($path)), array("onclick" => "if (!confirm('" . __('Are you sure you want to deactivate this extension?', $this -> plugin_name) . "')) { return false; }", 'class' => "submitdelete")); ?></span>
                                        
                                        <?php
										break;	
								}
								
								?>
                            </div>
                        </th>
                        <th>
                        	<?php 
							
							switch ($status) {
								case 0			:
									?><span style="color:red;"><?php _e('Not Installed', $this -> plugin_name); ?></span> <small>(<?php echo $wpcoHtml -> link(__('Buy Now', $this -> plugin_name), $extension['link'], array('target' => "_blank", 'onclick' => "jQuery.colorbox({title:'" . $extension['name'] . "', iframe:true, width:'80%', height:'80%', href:'" . $extension['link'] . "'}); return false;")); ?>)</small><?php
									break;
								case 1			:
									?><span style="color:red;"><?php _e('Installed but Inactive', $this -> plugin_name); ?></span><?php
									break;
								case 2			:
									?><span style="color:green;"><?php _e('Installed and Active', $this -> plugin_name); ?></span><?php
									break;	
							}
							
							?>
                        </th>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
    	<p class="<?php echo $this -> pre; ?>error"><?php _e('No extensions found.', $this -> plugin_name); ?></p>
    <?php endif; ?>
</div>