<?php
/**
 * Testimonials functions and definitions
 *
 * @package DW Page
 * @since DW Page 1.0
 */

/*-----------------------------------------------------------------------------------*/
/*	Register Testimonials post format.
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'testimonial_posttype_init' );
if ( !function_exists( 'testimonial_posttype_init' ) ) :
function testimonial_posttype_init() {

	$testimonial_labels = array(
		'name' => _x('Testimonials', 'post type general name','dw-page'),
		'singular_name' => _x('Testimonial', 'post type singular name','dw-page'),
		'add_new' => _x('Add New', 'testimonial','dw-page'),
		'add_new_item' => __('Add New Testimonial','dw-page'),
		'edit_item' => __('Edit Testimonial','dw-page'),
		'new_item' => __('New Testimonial','dw-page'),
		'all_items' => __('All Testimonials','dw-page'),
		'view_item' => __('View Testimonial','dw-page'),
		'search_items' => __('Search Testimonials','dw-page'),
		'not_found' =>  __('No testimonials found','dw-page'),
		'not_found_in_trash' => __('No testimonials found in Trash','dw-page'), 
		'parent_item_colon' => '',
		'menu_name' => __('Testimonials','dw-page')

	);
	$testimonial_args = array(
		'labels' => $testimonial_labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => false,
		'rewrite' => false,
		'capability_type' => 'post',
		'has_archive' => false, 
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri().'/assets/img/posttype-testimonial.png',
		'supports' => array( 'title' )
	); 
	register_post_type( 'testimonial', $testimonial_args );

}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Add Testimonial Metaboxes
/*-----------------------------------------------------------------------------------*/
// Add metabox
add_action('admin_init', 'testimonial_metabox');
function testimonial_metabox(){
	add_meta_box('testimonial-metabox', 'Testimonial Data', 'testimonial_metabox_callback', 'testimonial', 'normal');
}

// Metabox callback
function testimonial_metabox_callback() { ?>
	<input type="hidden" name="dw_page_post_id" id="dw_page_post_id" value="<?php echo get_the_ID(); ?>" />
	<table width="100%">	
		<tr class="alternate">
			<th class="left"><?php _e('Content','dw-page');  ?></th>
			<td>
				<p><textarea rows="2" cols="80" name="testimonial-content" id="testimonial-content"><?php echo get_post_meta(get_the_ID(), '_testimonial_content', true); ?></textarea></p>
			</td>
		</tr>
		<tr class="alternate">
			<th class="left"><?php _e('By (Name)','dw-page');  ?></th>
			<td>
				<p><input type="text" name="testimonial-name" id="testimonial-name" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_testimonial_name', true); ?>" ></p>
			</td>
		</tr>
		<tr class="alternate" >
			<th class="left"><?php _e('Avatar','dw-page') ?></th>
			<td>
				<p>
					<input type="text" id="testimonial-avatar" name="testimonial-avatar" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_testimonial_avatar', true); ?>" />
					<button onclick="return false" class="dw_page_upload_btn button" rel="#testimonial-avatar" ><?php _e('Upload image','dw-page'); ?></button><br />
					<span class="hint"><?php _e('Recommend width: 60px', 'dw-page'); ?></span>
				</p>
			</td>
		</tr>
		<tr class="alternate">
			<th class="left"><?php _e('Job title','dw-page');  ?></th>
			<td>
				<p><input type="text" name="testimonial-job" id="testimonial-job" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_testimonial_job', true); ?>" ></p>
			</td>
		</tr>
		<tr class="alternate">
			<th class="left"><?php _e('Company','dw-page');  ?></th>
			<td>
				<p><input type="text" name="testimonial-company" id="testimonial-company" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_testimonial_company', true); ?>" ></p>
			</td>
		</tr>
		<tr class="alternate">
			<th class="left"><?php _e('Website','dw-page');  ?></th>
			<td>
				<p><input type="text" name="testimonial-website" id="testimonial-website" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_testimonial_website', true); ?>" ></p>
			</td>
		</tr>
	</table>
<?php }

// Action when save post
add_action('save_post', 'admin_save_testimonial');
function admin_save_testimonial($post_id){
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	if( isset($_POST['post_type']) && 'testimonial' == $_POST['post_type'] ){
		if( !empty($_POST['testimonial-content']) ){
			update_post_meta($post_id, '_testimonial_content', $_POST['testimonial-content']);
		}
		if( !empty($_POST['testimonial-name']) ){
			update_post_meta($post_id, '_testimonial_name', $_POST['testimonial-name']);
		}
		if( !empty($_POST['testimonial-job']) ){
			update_post_meta($post_id, '_testimonial_job', $_POST['testimonial-job']);
		}
		if( !empty($_POST['testimonial-company']) ){
			update_post_meta($post_id, '_testimonial_company', $_POST['testimonial-company']);
		}
		if( !empty($_POST['testimonial-website']) ){
			update_post_meta($post_id, '_testimonial_website', $_POST['testimonial-website']);
		}
		if( !empty($_POST['testimonial-avatar']) ){
			update_post_meta($post_id, '_testimonial_avatar', $_POST['testimonial-avatar']);
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Testimonials List Shortcode
/*-----------------------------------------------------------------------------------*/
add_shortcode( "testimonials", "list_testimonials_shortcode" );
function list_testimonials_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		"number" => '9',
		"col" => '3'
	), $atts));

	$the_query = new WP_Query( 'post_type=testimonial&posts_per_page='.$number );

	if($the_query->have_posts()) :
	$testimonials = '<div class="testimonials row-fluid">';
	$i=0;
	while ( $the_query->have_posts() ) : $the_query->the_post();
		$span = 12/$col;
		if($i%$col==0) {
			$class = 'span'.$span.' first';
		} else {
			$class = 'span'.$span;
		}
		$testimonials.= '
	<div class="'.$class.'">
		<blockquote>
			<p>'. get_post_meta(get_the_ID(), '_testimonial_content', true) .'</p>
			<cite>
				<img src="'. get_post_meta(get_the_ID(), '_testimonial_avatar', true) .'" class="avatar" alt="" />
				<strong>'. get_post_meta(get_the_ID(), '_testimonial_name', true) .'</strong>
				'. get_post_meta(get_the_ID(), '_testimonial_job', true) .' at <a href="'. get_post_meta(get_the_ID(), '_testimonial_website', true) .'">'. get_post_meta(get_the_ID(), '_testimonial_company', true) .'</a>
			</cite>
		</blockquote>
	</div>';
	$i++;
	endwhile;
	$testimonials.= '</div>';
	endif;
	return $testimonials;
}

// Add shorcode description for slide post type table column
add_filter('manage_edit-slide_columns', 'slide_table_columns');
function slide_table_columns($columns) {
	$columns['slide_shortcode'] = __('Shortcode','dw-page');
	$columns['slide_function']  = __('Function','dw-page');
	return $columns;
}
