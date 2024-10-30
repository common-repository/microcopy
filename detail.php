<?php 
	global $wpdb; 
	if ( $this->action == "edit" ) { 
		$prefix = "";
		$title = __('Edit microcopy', 'microcopy');
		$option = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "options WHERE option_id = " . $this->id ); 
	} else {
		$prefix = "am_mc_";
		$title = __('Add new microcopy', 'microcopy');
	}
?>
<div id="microcopy" class="wrap detail">
	<div id="icon-edit-pages" class="icon32"><br /></div> 
	<h2>
		<?php echo $title; ?>
		<a href="<?php echo $this->baseurl; ?>" class="add-new-h2"><?php echo __('Back', 'microcopy'); ?></a>
	</h2><br/>
	<form name="addDestaque" method="post" action="<?php echo $this->baseurlDetail; ?>&action=edit&id=<?php $option->option_id; ?>">
		<input type="hidden" name="micro-copy" value="true" />
		<input type="hidden" name="option_id" value="<?php echo $option->option_id; ?>" />
		<div id="titlediv">
			<div id="titlewrap">
				<label><?php echo __('Insert option name', 'microcopy'); ?>:</label>
				<input size="30" id="title" type="text" class="shortcode-option-name" name="option_name" value="<?php echo $prefix . $option->option_name; ?>" />
				<small>(<?php echo __('insert always the prefix <b>am_mc_</b> before putting the name of the desired option, use only small letters and underscores', 'microcopy'); ?> ).</small>
			</div>
		</div>
		<p>
			<?php the_editor( stripslashes($option->option_value) ); ?>
		</p>
		<?php submit_button( __('Save Microcopy', 'microcopy') ); ?>
	</form>
</div>
