<?php
	global $wpdb;
	$query = "SELECT * 
			FROM  " . $wpdb->prefix . "options 
			WHERE  option_name LIKE  'am_mc_%' 
			ORDER BY option_id ASC";
	$microCopies = $wpdb->get_results( $query );
?>	
	<div id="microcopy" class="wrap"> 
		<div id="icon-edit-pages" class="icon32"><br /></div> 
		<h2>Microcopy <a href="<?php echo $this->baseurlDetail; ?>" class="add-new-h2"><?php echo __('Add New', 'microcopy'); ?></a></h2>
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder columns-1">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_right_now" class="postbox ">
						<h3 style="cursor: default;">
							<span><?php echo __('How to use', 'microcopy'); ?>?</span>
						</h3>
						<div class="inside">
							<div class="table">
								<p class="sub">
									<?php echo __('To use Microcopy, just click', 'microcopy'); ?> <a href="<?php echo $this->baseurlDetail; ?>" class="add-new-h2"><?php echo __('Add New', 'microcopy'); ?></a>, <?php echo __('insert the option name, the content and save', 'microcopy'); ?>.<br/>
									<?php echo __('After these steps, just add the <b>Shortcode</b> into the code of your template', 'microcopy'); ?>.<br/>
									<?php echo __('For instance, if you create an <b>Option</b> with the name am_mc_foo the <b>Shortcode</b> to insert in your template is', 'microcopy'); ?>:
								</p>
								<table>
									<tbody>
										<tr class="first">
											<td class="t cats">
												<?php 
													$string = "<?php echo do_shortcode('[am_mc foo]'); ?>";
													highlight_string($string);
												?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<br class="clear"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php if ( count($microCopies) > 0) { ?>
		<table class="widefat page fixed" cellspacing="0"> 
			<thead> 
				<tr>
					<th scope="col" id="id" class="manage-column column-id" style="" width="50">ID</th> 
					<th scope="col" id="nome" class="manage-column column-nome" style="" width="150"><?php echo __('Option name', 'microcopy'); ?></th> 
					<th scope="col" id="valor" class="manage-column column-valor" style=""><?php echo __('Value', 'microcopy'); ?></th> 
					<th scope="col" id="editar" class="manage-column column-editar" style="" width="50"></th> 
					<th scope="col" id="remover" class="manage-column column-remover" style="" width="50"></th> 
					<th scope="col" id="shortcode" class="manage-column column-shortcode" style=""><?php echo __('Shortcode', 'microcopy'); ?></th> 
				</tr> 
			</thead> 
			<tfoot> 
				<tr> 
					<th scope="col" id="id" class="manage-column column-id" style="">ID</th> 
					<th scope="col" id="nome" class="manage-column column-nome" style=""><?php echo __('Option name', 'microcopy'); ?></th> 
					<th scope="col" id="valor" class="manage-column column-valor" style=""><?php echo __('Value', 'microcopy'); ?></th> 
					<th scope="col" id="editar" class="manage-column column-editar" style=""></th> 
					<th scope="col" id="remover" class="manage-column column-remover" style=""></th> 
					<th scope="col" id="shortcode" class="manage-column column-shortcode" style=""><?php echo __('Shortcode', 'microcopy'); ?></th> 
				</tr> 
			</tfoot> 
			<tbody> 
				<?php $i = 0; ?>
				<?php foreach($microCopies as $micro ) { ?>
					<?php $i++; ?>
					<tr class="alternate"> 
						<td><?php echo $micro->option_id; ?></td> 
						<td>
							<?php 
								$name = str_replace('am_mc_', '', $micro->option_name);
								echo $name; 
							?>
						</td> 
						<td><?php echo substr( stripslashes($micro->option_value), 0, 100 ) . '...'; ?></td> 
						<td><a href="<?php echo $this->baseurlDetail; ?>&action=edit&id=<?php echo $micro->option_id; ?>"><?php echo __('Edit', 'microcopy'); ?></a></td> 
						<td>
							<a href="<?php echo $this->baseurl; ?>&action=remove&id=<?php echo $micro->option_id; ?>" onclick="return confirm('<?php echo __('Are you sure you want to remove this Microcopy', 'microcopy'); ?>?\n(<?php echo __('this step is irreversible', 'microcopy'); ?>)')"><?php echo __('Remove', 'microcopy'); ?></a>
						</td> 
						<td>
							<?php $string = "<?php echo do_shortcode('[am_mc " . $name . "]'); ?>"; ?>
							<a id="copy-microcopy<?php echo '-' . $i; ?>" href="#" title="<?php echo $string; ?>" onClick="openWindow(<?php echo $i; ?>);">
								<?php echo __('Copy', 'microcopy'); ?> 
							</a>
							<div id="copy-microcopy-container<?php echo '-' . $i; ?>" class="microcopy-shortcode">
								<div class="value-container">
									<p><?php echo __('Copy and insert this shortcode in the desired place', 'microcopy'); ?> :</p> 
									<?php highlight_string($string); ?>
									<a class="close" href="#" onClick="closeWindow(<?php echo $i; ?>);">X</a>
								</div>
							</div>
						</td> 
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php
		} else {
			echo "<p>" . __('Currently there is no Micocopy', 'microcopy') . ".</p>";
		}
	?>
