<?php
/*
Plugin Name: Categories by Tag Table
Plugin URI: http://wordpress.org/extend/plugins/cat-by-tags-table/
Description: Display all your Categories as rows and Tags as columns in a html table.
Version: 1.04
Author: haroldstreet
Author URI: http://www.haroldstreet.org.uk/other/?page_id=266
License: GPL2
*/

$display_cats_by_tag_textdomain = 'display_cats_by_tag';

// Add the page to the options menu
function display_cats_by_tag_admin_menu() {
	global $display_cats_by_tag_textdomain;
	add_options_page(__('Display Categories by Tag Table:', $display_cats_by_tag_textdomain), __('Categories by Tag', $display_cats_by_tag_textdomain), 'manage_options', __FILE__, 'display_cats_by_tag_admin_page');

	// WPMU 2.7
	if ( function_exists('register_setting') ) {
		register_setting('display_cats_by_tag_options','display_cats_by_tag_direction');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_table_title');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_cell_style');
		register_setting('display_cats_by_tag_options','display_cats_by_tag_emptycell');
	}
}

/**
 * The Admin page
 */
function display_cats_by_tag_admin_page() {
	global $display_cats_by_tag_version, $display_cats_by_tag_textdomain;
	$optionvars = array(
		'display_cats_by_tag_direction',
		'display_cats_by_tag_table_title',
		'display_cats_by_tag_cell_style',
		'display_cats_by_tag_emptycell');
?>
<div class="wrap">
	<h2><?php _e('Categories by Tags Table:', $display_cats_by_tag_textdomain); ?></h2>
	<p><strong><?php _e('Categories by Tag Table', $display_cats_by_tag_textdomain); ?></strong> <?php _e('allows you to display a table of all your Categories and tags.<br />Each cell displays the number of posts that are in both the category and have the tag &amp; a link to those posts.', $display_cats_by_tag_textdomain); ?></p>

	<form action="options.php" method="post">
		<?php if (function_exists('settings_fields')) { settings_fields('display_cats_by_tag_options'); } else if (function_exists('wp_nonce_field')) { wp_nonce_field('update-options'); ?>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="<?php echo join(',', $optionvars); ?>"/>
	<?php } // if nonce_field ?>

		<!-- Set Table Direction -->
		<p><?php _e(''); ?> <strong><?php _e('Table Direction', $display_cats_by_tag_textdomain); ?></strong>?<br />
			<input type="radio" name="display_cats_by_tag_direction" id="display_cats_by_tag_direction_yes" value="1"<?php if (get_option('display_cats_by_tag_direction')==1):?> checked="checked"<?php endif; ?> /> <label for="display_cats_by_tag_direction_yes"><?php _e('Categories as rows with tags as columns', $display_cats_by_tag_textdomain); ?></label> &nbsp;
			<input type="radio" name="display_cats_by_tag_direction" id="display_cats_by_tag_direction_no" value="0"<?php if ( get_option('display_cats_by_tag_direction')!=1):?> checked="checked"<?php endif; ?> /> <label for="display_cats_by_tag_direction_no"><?php _e('Tags as rows with Categories as columns', $display_cats_by_tag_textdomain); ?></label></p>

		<!-- Text for Categories in Table -->
		<p><?php _e('What text would you like in the first cell of the table', $display_cats_by_tag_textdomain); ?><br />
			<label for="display_cats_by_tag_table_title"><strong><?php _e('Text:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_table_title" id="display_cats_by_tag_table_title" value="<?php echo get_option('display_cats_by_tag_table_title'); ?>" style="width: 50%" />
			<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_table_title').value='<h3>Categories by Tags</h3>';"><?php _e('default'); ?></a>)</small></p>

		<!-- Text for Tabs in Table -->
		<p><?php _e('What style would you like for the table <td> cells', $display_cats_by_tag_textdomain); ?><br />
			<label for="display_cats_by_tag_cell_style"><strong><?php _e('CSS Style:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_cell_style" id="display_cats_by_tag_cell_style" value="<?php echo get_option('display_cats_by_tag_cell_style'); ?>" style="width: 50%" />
			<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_cell_style').value='border:1px solid #ccc;width:1em;';"><?php _e('default'); ?></a>)</small></p>

		<!-- Text for Tabs in Table -->
		<p><?php _e('What  would you like to display in any empty cells', $display_cats_by_tag_textdomain); ?><br />
			<label for="display_cats_by_tag_cell_style"><strong><?php _e('Empty Cell Text:', $display_cats_by_tag_textdomain); ?></strong></label> <input type="text" name="display_cats_by_tag_emptycell" id="display_cats_by_tag_emptycell" value="<?php echo get_option('display_cats_by_tag_emptycell'); ?>" style="width: 50%" />
			<small>(<a href="javascript:;" onclick="document.getElementById('display_cats_by_tag_emptycell').value='&nbsp;';"><?php _e('default'); ?></a>)</small></p>


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
<?php
}

//Make the TABLE HTML CODE
function display_cats_by_tag() {
	global $id, $wpdb;
	// now we need to get a couple settings
	$direction=get_option('display_cats_by_tag_direction') ;
	$emptycell=get_option('display_cats_by_tag_emptycell') ;
	$tabletitletxt = get_option('display_cats_by_tag_table_title') ;
	$cellstyletxt = get_option('display_cats_by_tag_cell_style') ;
	if($tabletitletxt==''){$tabletitletxt="<h3>Categories by Tags</h3>";}
	if($cellstyletxt==''){$cellstyletxt="border:1px solid #ccc;width:1em;";}

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

	$tablehtml = '<table style="border-collapse:collapse;">'; //START HTML
	//HEADER ROW
	if($direction==1){// CATS BY TAG
		$tablehtml .= '<thead style="max-height:15em;"><th style="'.$cellstyletxt.'">'.$tabletitletxt.'</td>'; //TAG Title Line
			$tags=get_categories($tag_args);
			foreach($tags as $tag) {
				$tablehtml .= '<td style="height:100%;vertical-align:bottom;'.$cellstyletxt.'">';
				// If Internet Explorer do the nifty rotate text thing...
				$tablehtml .= '<!--[If IE]><div style="writing-mode:tb-rl; filter:flipv fliph;max-height:7em;"><![endif]-->';
				// If NOT Internet Explorer do this instead...
				$tablehtml .= '<!--[if !IE]>-->';
				$tablehtml .= '<div style="max-width:0.5em;max-width:0.5em;word-wrap:break-word;font-family:\'Lucida Console\',Monotype; ">';
				$tablehtml .= '<!--<![endif]-->';

				$tablehtml .= '<div style="vertical-align:bottom">';
				$tablehtml .= '<a style="vertical-align:bottom;" href="?tag='.urlencode($tag->slug).'">'.substr(str_replace("Sym:","",str_replace("Flowers:","",str_replace("|","",str_replace(" ","",str_replace("-","",$tag->name))))),0,10).'</a>';
				$tablehtml .= '</div>';
				$tablehtml .= '</div>';
				$tablehtml .= '</th>';
			}
		$tablehtml .= '</thead>';

		//TABLE ROWS
		$categories=get_categories($cat_args);
		foreach($categories as $category) {

			$catID=$category->term_id;
			$tablehtml .= '<tr><td style="'.$cellstyletxt.'"><a href="' . get_category_link( $catID ) . '" title="' . sprintf( __( "View all %s" ), $category->name ) . '" ' . '>' . $category->name.'</a></td>';

			$tags=get_categories($tag_args);
			foreach($tags as $tag) {

				$tagID=$tag->term_id;

				$countsql ="SELECT COUNT(*) FROM ( ";
				$countsql.="(SELECT object_id AS tag_object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = ".$tagID." ) AS tags ";
				$countsql.="INNER JOIN ";
				$countsql.="(SELECT object_id AS cat_object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = ".$catID." ) AS cats ";
				$countsql.="ON tag_object_id = cat_object_id ) ";

				$countresult = mysql_query($countsql) or die(mysql_error());
				$countfrow = mysql_fetch_array($countresult) ;
				$count = $countfrow[0] ;

				$tablehtml .= '<td style="'.$cellstyletxt.'">';
				if($count>=1){$tablehtml .= '<a href="'.get_category_link( $catID ).'&amp;tag='.urlencode($tag->slug).'" title="View '.$count." ".sprintf( __( "%s" ), str_replace("|","",str_replace(" ","",str_replace("-","",$tag->name))) ).sprintf( __( " %s" ), $category->name ).'"><b>'.$count.'</b></a>';}
				else {$tablehtml .= $emptycell;}
				$tablehtml .= '</td>';
			}
		$tablehtml .= '</tr>';
		}
	} else {// TAGS BY CAT
		$tablehtml .= '<thead style="max-height:15em;"><th style="'.$cellstyletxt.'">'.$tabletitletxt.'</td>'; //cat Title Line
			$cats=get_categories($cat_args);
			foreach($cats as $cat) {
				$catID=$cat->term_id;
				$tablehtml .= '<td style="height:100%;vertical-align:bottom;'.$cellstyletxt.'">';
				// If Internet Explorer do the nifty rotate text thing...
				$tablehtml .= '<!--[If IE]><div style="writing-mode:tb-rl; filter:flipv fliph;max-height:7em;"><![endif]-->';
				// If NOT Internet Explorer do this instead...
				$tablehtml .= '<!--[if !IE]>-->';
				$tablehtml .= '<div style="max-width:0.5em;max-width:0.5em;word-wrap:break-word;font-family:\'Lucida Console\',Monotype; ">';
				$tablehtml .= '<!--<![endif]-->';

				$tablehtml .= '<div style="vertical-align:bottom">';
				$tablehtml .= '<a style="vertical-align:bottom;" href="'.get_category_link( $catID ).'">'.substr(str_replace("Sym:","",str_replace("Flowers:","",str_replace("|","",str_replace(" ","",str_replace("-","",$cat->name))))),0,10).'</a>';
				$tablehtml .= '</div>';
				$tablehtml .= '</div>';
				$tablehtml .= '</th>';
			}
		$tablehtml .= '</thead>';

		//TABLE ROWS
		$tags=get_categories($tag_args);
		foreach($tags as $tag) {

			$tagID=$tag->term_id;
			$tablehtml .= '<tr><td style="'.$cellstyletxt.'"><a href="?tag='.urlencode($tag->slug).'" title="' . sprintf( __( "View all %s" ), $tag->name ) . '" ' . '>' . $tag->name.'</a></td>';

			$cats=get_categories($cat_args);
			foreach($cats as $cat) {

				$catID=$cat->term_id;

				$countsql ="SELECT COUNT(*) FROM ( ";
				$countsql.="(SELECT object_id AS cat_object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = ".$catID." ) AS cats ";
				$countsql.="INNER JOIN ";
				$countsql.="(SELECT object_id AS tag_object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = ".$tagID." ) AS tags ";
				$countsql.="ON cat_object_id = tag_object_id ) ";

				$countresult = mysql_query($countsql) or die(mysql_error());
				$countfrow = mysql_fetch_array($countresult) ;
				$count = $countfrow[0] ;

				$tablehtml .= '<td style="'.$cellstyletxt.'">';
				if($count>=1){$tablehtml .= '<a href="'.get_category_link( $catID ).'&amp;tag='.urlencode($tag->slug).'" title="View '.$count." ".sprintf( __( "%s" ), str_replace("|","",str_replace(" ","",str_replace("-","",$tag->name))) ).sprintf( __( " %s" ), $category->name ).'"><b>'.$count.'</b></a>';}
				else {$tablehtml .= $emptycell;}
				$tablehtml .= '</td>';
			}
		$tablehtml .= '</tr>';
		}
	}
	$tablehtml .= '</table>';

	return $tablehtml;
}

/**
 * The filter to insert the table
 */
function display_cats_by_tag_filter( $content ) {
	global $id, $wpdb;

	// REPLACE "[CATS_BY_TAGS_TABLE]" with the table html code
	return preg_replace('#'.preg_quote('[CATS_BY_TAGS_TABLE]', '#').'#', display_cats_by_tag(), $content, 1);
}

/**
 * Activation Hook to add settings
 */
function display_cats_by_tag_activate () {
	// Add the options
	add_option('display_cats_by_tag_direction', 1, 'Table Direction; Categories by tag or Tags by Categories', 'yes');
	add_option('display_cats_by_tag_table_title', '<h3>Categories by Tags</h3>', 'Give the Table title', 'yes');
	add_option('display_cats_by_tag_cell_style', 'border:1px solid #ccc;width:1em;', 'Customise the style of the table cells', 'yes');
	add_option('display_cats_by_tag_emptycell', '&nbsp;', 'Content for empty cells', 'yes');
}

/**
 * Deactivation Hook to remove settings
 */
function display_cats_by_tag_deactivate () {
	// Remove the options
	delete_option('display_cats_by_tag_direction');
	delete_option('display_cats_by_tag_table_title');
	delete_option('display_cats_by_tag_cell_style');
	delete_option('display_cats_by_tag_emptycell');
}

// Register everything
load_plugin_textdomain($display_cats_by_tag_textdomain, 'wp-content/plugins/cat-by-tags-table');
register_activation_hook(__FILE__, 'display_cats_by_tag_activate');
register_deactivation_hook(__FILE__, 'display_cats_by_tag_deactivate');
add_action('admin_menu', 'display_cats_by_tag_admin_menu');
add_filter('the_content', 'display_cats_by_tag_filter', 50);
?>
