<p><?php echo $wpcoHtml -> link(__('&laquo; Back to your account', $this -> plugin_name), $wpcoHtml -> account_url()); ?></p>
<h3><?php _e('Downloads Management', $this -> plugin_name); ?></h3>

<?php if (!empty($files)) : ?>
	<form action="" method="">
		<table class="<?php echo $this -> pre; ?>">
			<thead>
				<tr>
					<th><?php _e('File Name', $this -> plugin_name); ?></th>
					<th><?php _e('File Size', $this -> plugin_name); ?></th>
					<th><?php _e('File Type', $this -> plugin_name); ?></th>
					<th><?php _e('Modified Date', $this -> plugin_name); ?></th>
					<th></th>
				</tr>
			</thead>
            <tfoot>
            	<tr>
					<th><?php _e('File Name', $this -> plugin_name); ?></th>
					<th><?php _e('File Size', $this -> plugin_name); ?></th>
					<th><?php _e('File Type', $this -> plugin_name); ?></th>
					<th><?php _e('Modified Date', $this -> plugin_name); ?></th>
					<th></th>
				</tr>
            </tfoot>
			<tbody>
				<?php $class = ''; ?>
				<?php foreach ($files as $file) : ?>
                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                        <td><?php echo $wpcoHtml -> link($file -> title, $wpcoHtml -> retainquery($this -> pre . 'method=download&id=' . $file -> id, $wpcoHtml -> account_url()), array('title' => $file -> title)); ?></td>
                        <td><?php echo (empty($file -> filesize)) ? __('unknown', $this -> plugin_name) : (number_format((($file -> filesize/1024)/1024), 2, '.', '')) . __('Mb', $this -> plugin_name); ?></td>
                        <td><?php echo (empty($file -> filetype)) ? __('unknown', $this -> plugin_name) : $file -> filetype; ?></td>
                        <td><abbr title="<?php echo $file -> modified; ?>"><?php echo date("Y-m-d", strtotime($file -> modified)); ?></abbr></td>
                        <td><?php echo $wpcoHtml -> link('<img style="border:none;" src="' . $this -> url() . '/images/drive_go.png" alt="' . __('download', $this -> plugin_name) . '" />', $wpcoHtml -> retainquery($this -> pre . "method=download&amp;id=" . $file -> id, $wpcoHtml -> account_url()), array('title' => __('Download', $this -> plugin_name) . ' : ' . $file -> title)); ?></td>
                    </tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>
<?php else : ?>
	<div class="<?php echo $this -> pre; ?>error"><?php _e('No downloads are available', $this -> plugin_name); ?></div>
<?php endif; ?>