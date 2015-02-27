<?php
/*
Plugin Name: Categories by Tag Table
Plugin URI: http://wordpress.org/extend/plugins/cat-by-tags-table/
Description: Display all your Categories as rows and Tags as columns in a html pivot table.
Version: 2.11
Author: haroldstreet
Author URI: http://www.haroldstreet.org.uk/other/?page_id=266
License: GPL2
*/

$display_cats_by_tag_textdomain = 'display_cats_by_tag';

// Add the page to the options menu
function display_cats_by_tag_admin_menu() {
	global $display_cats_by_tag_textdomain;
	if ( function_exists('add_options_page') ) {
		add_options_page(__('Categories by Tag Table', $display_cats_by_tag_textdomain), __('Categories by Tag', $display_cats_by_tag_textdomain), 'manage_options', __FILE__, 'display_cats_by_tag_admin_page');
	}

	if ( function_exists('register_setting') ) {
		register_setting('display_cats_by_tag_options','display_cats_by_tag_direction');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_table_title');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_stylesheet');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_replace_text');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_empty_cell');
	}
}

//The Admin page
function display_cats_by_tag_admin_page() {
	global $display_cats_by_tag_version, $display_cats_by_tag_textdomain;
	$optionvars = array(
		'display_cats_by_tag_direction',
		'display_cats_by_tag_table_title',
		'display_cats_by_tag_stylesheet',
		'display_cats_by_tag_replace_text',
		'display_cats_by_tag_empty_cell');
	?><div class="wrap">
		<h2><div id="icon-themes" class="icon32"></div><?php _e('Categories by Tags Table', $display_cats_by_tag_textdomain); ?></h2>
		<p><strong><?php _e('Categories by Tag Table', $display_cats_by_tag_textdomain); ?></strong> <?php _e('allows you to display a table of all your Categories and tags.<br />Each cell displays the number of posts that are in both the category and have the tag &amp; a link to those posts.', $display_cats_by_tag_textdomain); ?></p>

		<form action="options.php" method="post">
			<?php if (function_exists('settings_fields')) { settings_fields('display_cats_by_tag_options'); } else if (function_exists('wp_nonce_field')) { wp_nonce_field('update-options'); ?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="<?php echo join(',', $optionvars); ?>"/>
			<?php } // if nonce_field ?>

			<!-- Set Table Direction -->
			<p><strong><?php _e('Table Direction:', $display_cats_by_tag_textdomain); ?></strong><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="display_cats_by_tag_direction" id="display_cats_by_tag_direction_yes" value="1"<?php if (get_option('display_cats_by_tag_direction')==1):?> checked="checked"<?php endif; ?> /> <label for="display_cats_by_tag_direction_yes"><?php _e('Categories as rows with tags as columns', $display_cats_by_tag_textdomain); ?></label><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="display_cats_by_tag_direction" id="display_cats_by_tag_direction_no" value="0"<?php if ( get_option('display_cats_by_tag_direction')!=1):?> checked="checked"<?php endif; ?> /> <label for="display_cats_by_tag_direction_no"><?php _e('Tags as rows with Categories as columns', $display_cats_by_tag_textdomain); ?></label></p>

			<!-- Text for Categories in Table -->
			<p><?php _e('What title text would you like in the first cell of the table', $display_cats_by_tag_textdomain); ?><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="display_cats_by_tag_table_title"><strong><?php _e('Title Text:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_table_title" id="display_cats_by_tag_table_title" value="<?php echo get_option('display_cats_by_tag_table_title'); ?>" style="width: 50%" />
				<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_table_title').value='<h3>Categories by Tags</h3>';"><?php _e('default'); ?></a>)</small></p>

			<!-- Text for Tabs in Table -->
			<p><?php _e('What external CSS stylesheet would you like to use - give URL', $display_cats_by_tag_textdomain); ?><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="display_cats_by_tag_stylesheet"><strong><?php _e('CSS Stylesheet:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_stylesheet" id="display_cats_by_tag_stylesheet" value="<?php echo get_option('display_cats_by_tag_stylesheet'); ?>" style="width: 75%" />
				<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_stylesheet').value='default-css-settings.css';"><?php _e('default'); ?></a>)</small></p>

			<!-- Text for empty cells in Table -->
			<p><?php _e('What text would you like to display in any empty cells', $display_cats_by_tag_textdomain); ?><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="display_cats_by_tag_empty_cell"><strong><?php _e('Text for Empty Cell:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_empty_cell" id="display_cats_by_tag_empty_cell" value="<?php echo get_option('display_cats_by_tag_empty_cell'); ?>" style="width: 40%" />
				<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_empty_cell').value='&nbsp;';"><?php _e('default'); ?></a>)</small></p>

			<!-- Text to Remove from Cats & Tags -->
			<p><?php _e('Remove the following characters from Tag &amp; Category names', $display_cats_by_tag_textdomain); ?><br />
			<?php _e("You can separate a list of characters &amp; text phrases with commas ',' only (i.e. no spaces)", $display_cats_by_tag_textdomain); ?><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="display_cats_by_tag_replace_text"><strong><?php _e('Remove Text:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_replace_text" id="display_cats_by_tag_replace_text" value="<?php echo get_option('display_cats_by_tag_replace_text'); ?>" style="width: 45%" />
				<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_replace_text').value='';"><?php _e('default'); ?></a>)</small></p>


			<!-- submit the form -->
			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" />
			</p>
		</form>

		<!--Please-Donate-Start-->
		<h3>If you like this plugin - please donate to say thanks</h3>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="NR4YY3ZNYXWKU">
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
		</form>
		<!--Please-Donate-End-->

	</div>
<?php }

//Make the TABLE HTML CODE
function display_cats_by_tag() {
	global $id, $wpdb;
	// now we need to get a couple settings
	$direction=get_option('display_cats_by_tag_direction') ;
	$emptycell=get_option('display_cats_by_tag_empty_cell') ;
	$replace_text=explode(",",get_option('display_cats_by_tag_replace_text')) ;
	$tabletitletxt = get_option('display_cats_by_tag_table_title') ;
	$cellstyletxt = get_option('display_cats_by_tag_stylesheet') ;
	if($tabletitletxt==''){$tabletitletxt='<h3>Categories by Tags</h3>';}
	if($cellstyletxt==''){$cellstyletxt="default-css-settings.css";}

	// then make the code to insert
	$cat_args=array(
	  'orderby' => 'name',
	  'order' => 'ASC',
	  'taxonomy' => 'category'
	  );

	$tag_args=array(
	  'orderby' => 'name',
	  'order' => 'ASC',
	  'taxonomy' => 'post_tag'
	  );

	$tablehtml = '<div id="catbytag"><table style="border-collapse:collapse;">'; //START HTML
	//HEADER ROW
	$tablehtml .= '<thead class="catbytag"><th class="catbytag-title">'.$tabletitletxt.'</th>'; //TAG Title Line
	if($direction==1){ // CATS BY TAG
		$cols=get_categories($tag_args);
	}else{  // TAGS BY CAT
		$cols=get_categories($cat_args);
	}
	foreach($cols as $col) {

		$tablehtml .= '<th class="catbytag">';
		// If Internet Explorer do the nifty rotate text thing...
		$tablehtml .= '<!--[if IE]><div class="catbytag_IEONLY"><![endif]-->';
		// If NOT Internet Explorer do the next best thing instead...
		$tablehtml .= '<!--[if !IE]>-->';
		$tablehtml .= '<div class="catbytag_NOT_IE">';
		$tablehtml .= '<!--<![endif]-->';
		$tablehtml .= '<div class="catbytag-column-heading">';

		if($direction==1){ // CATS BY TAG
			$tablehtml .= '<a href="?tag='.urlencode($col->slug).'">';
		}else{ // TAGS BY CAT
			$tablehtml .= '<a href="'.get_category_link( $col->term_id ).'">';
		}

		$name = substr(str_replace($replace_text,"",$col->name),0,15);
		$tablehtml .= $name.'</a>';

		$tablehtml .= '</div>';
		$tablehtml .= '</div>';
		$tablehtml .= '</th>';
	}
	$tablehtml .= '</thead>';

	//TABLE ROWS
	if($direction==1){ // CATS BY TAG
		$rows=get_categories($cat_args);
	}else{ // TAGS BY CAT
		$rows=get_categories($tag_args);
	}
	foreach($rows as $row) {
		$tablehtml .= '<tr><td class="catbytag-row-heading"><a href="';
		if($direction==1){  // CATS BY TAG
			$tablehtml .= get_category_link( $row->term_id );
			$cols=get_categories($tag_args);
		}else{ // TAGS BY CAT
			$tablehtml .= '?tag='.urlencode($row->slug);
			$cols=get_categories($cat_args);
		}

		$rowname = str_replace($replace_text,"",$row->name);
		$tablehtml .= '" title="' . sprintf( __( "View all %s" ), $row->name ) . '" ' . '>' . $rowname.'</a></td>';
		foreach($cols as $col) {

			$colID=$col->term_id;

			$countsql ="SELECT COUNT(A.object_id) AS countposts FROM $wpdb->term_relationships AS A ";
			$countsql.="JOIN $wpdb->term_taxonomy AS B ON A.`term_taxonomy_id` = B.`term_taxonomy_id` ";
			$countsql.="JOIN $wpdb->term_relationships AS C ON C.object_id = A.object_id ";
			$countsql.="JOIN $wpdb->term_taxonomy AS D ON C.`term_taxonomy_id` = D.`term_taxonomy_id` AND D.term_id = ".$row->term_id." ";
			$countsql.="JOIN $wpdb->posts AS E ON E.`ID` = A.object_id AND E.post_status = 'publish' ";
			$countsql.="WHERE B.term_id = ".$col->term_id." ";

			$countresult = mysql_query($countsql) or die(mysql_error());
			$countfrow = mysql_fetch_array($countresult) ;
			$count = $countfrow['countposts'] ;

			$tablehtml .= '<td class="catbytag">';
			if($count>=1){
				if($direction==1){ // CATS BY TAG
					$catID = $row->term_id;
					$tagslug = $col->slug;
					$tagname = $col->name;
					$catname = $row->name;
				}else{  // TAGS BY CAT
					$catID = $col->term_id;
					$tagslug = $row->slug;
					$tagname = $row->name;
					$catname = $col->name;
				}
				$tablehtml .= '<a href="'.get_category_link( $catID ).'?&amp;tag='.urlencode($tagslug).'" title="View '.$count." ".sprintf( __( "%s" ), $tagname ).sprintf( __( " %s" ), $catname ).'"><b>'.$count.'</b></a>';
			}else{$tablehtml .= $emptycell;}
			$tablehtml .= '</td>';
		}
	$tablehtml .= '</tr>';
	}
	$tablehtml .= '</table></div>';

	return $tablehtml;
}

//The filter to insert the table
function display_cats_by_tag_filter( $content ) {
	global $id, $wpdb;

	// REPLACE "[CATS_BY_TAGS_TABLE]" with the table html code
	return preg_replace('#'.preg_quote('[CATS_BY_TAGS_TABLE]', '#').'#', display_cats_by_tag(), $content, 1);
}

//Activation Hook to add settings
function display_cats_by_tag_activate () {
	// Add the options
	if ( function_exists('update_option') ) {
		update_option('display_cats_by_tag_direction', 1);
		update_option('display_cats_by_tag_table_title', '<h3>Categories by Tags</h3>');
		update_option('display_cats_by_tag_stylesheet', 'default-css-settings.css');
		update_option('display_cats_by_tag_replace_text', '');
		update_option('display_cats_by_tag_empty_cell', '&nbsp;');
	}
}

//Deactivation Hook to remove settings
function display_cats_by_tag_deactivate () {
	// Remove the options
	if ( function_exists('delete_option') ) {
		delete_option('display_cats_by_tag_direction');
		delete_option('display_cats_by_tag_table_title');
		delete_option('display_cats_by_tag_stylesheet');
		delete_option('display_cats_by_tag_replace_text');
		delete_option('display_cats_by_tag_empty_cell');
	}
}

function addHeaderCode() {
	echo "<!-- START CATS-BY-TAG HEADER -->\n";
	$cellstyletxt = get_option('display_cats_by_tag_stylesheet') ;
	if(($cellstyletxt=='')||($cellstyletxt=="default-css-settings.css")){
		echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/cat-by-tags-table/'.$cellstyletxt.'" />' . "\n" ;
	} else {
		echo '<link type="text/css" rel="stylesheet" href="'.$cellstyletxt.'" />' . "\n" ;
	}
	echo "<!-- END CATS-BY-TAG HEADER -->\n";
}

// Register everything
load_plugin_textdomain($display_cats_by_tag_textdomain);
register_activation_hook(__FILE__, 'display_cats_by_tag_activate');
register_deactivation_hook(__FILE__, 'display_cats_by_tag_deactivate');
add_action('admin_menu', 'display_cats_by_tag_admin_menu');
add_filter('the_content', 'display_cats_by_tag_filter', 10);
add_action('wp_head', 'addHeaderCode');

//NO CLOSING PHP MARKS!!!