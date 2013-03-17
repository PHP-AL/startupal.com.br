<?php
/**
 * Clients functions and definitions
 *
 * @package DW Page
 * @since DW Page 1.0
 */

/*---------------------------------------------------------------------------*/
/* Register Clients post format
/*---------------------------------------------------------------------------*/
add_action( 'init', 'client_posttype_init' );
if ( !function_exists( 'client_posttype_init' ) ) :
function client_posttype_init() {

	$client_labels = array(
		'name' => _x('Clients', 'post type general name','dw-page'),
		'singular_name' => _x('Client', 'post type singular name','dw-page'),
		'add_new' => _x('Add New', 'client','dw-page'),
		'add_new_item' => __('Add New Client','dw-page'),
		'edit_item' => __('Edit Client','dw-page'),
		'new_item' => __('New Client','dw-page'),
		'all_items' => __('All Clients','dw-page'),
		'view_item' => __('View Client','dw-page'),
		'search_items' => __('Search Clients','dw-page'),
		'not_found' =>  __('No clients found','dw-page'),
		'not_found_in_trash' => __('No clients found in Trash','dw-page'), 
		'parent_item_colon' => '',
		'menu_name' => __('Clients','dw-page')
	);

	$client_args = array(
		'labels' => $client_labels,
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
		'menu_icon' => get_template_directory_uri().'/assets/img/posttype-client.png',
		'supports' => array( 'title', 'thumbnail' )
	); 
	register_post_type( 'client', $client_args );

}
endif;

/*---------------------------------------------------------------------------*/
/* Add Client Metaboxes
/*---------------------------------------------------------------------------*/
// Add metabox
function client_metabox(){
	add_meta_box('client-metabox', 'Client Data', 'client_metabox_callback', 'client', 'normal');
}
add_action('admin_init', 'client_metabox');


if( !function_exists('client_metabox_callback') ){
	// Callback function for client-metabox
	function client_metabox_callback() {
		$id = get_the_ID();
	?>
		<input type="hidden" name="dw_page_post_id" id="dw_page_post_id" value="<?php echo $id; ?>" />
		<table width="100%">	
			<tr class="alternate">
				<th class="left"><?php _e('Client URL','dw-page');  ?></th>
				<td>
					<p><input type="text" name="client-url" id="client-url" class="regular-text" value="<?php echo get_post_meta($id, '_client_url', true); ?>" ></p>
				</td>
			</tr>
			<tr class="alternate">
				<th class="left"><?php _e('Client Logo','dw-page');  ?></th>
				<td>
					<p>
						<input type="text" id="client-logo" name="client-logo" class="regular-text" value="<?php echo get_post_meta($id, '_client_logo', true); ?>" />
						<button onclick="return false" class="dw_page_upload_btn button" rel="#client-logo" ><?php _e('Upload image','dw-page'); ?></button><br />
						<span class="hint"><?php _e('Recommend width: 60px', 'dw-page'); ?></span>
					</p>
				</td>
			</tr>
		</table>
	<?php }
}



if( !function_exists('admin_save_client') ){
	/**
	 * Save client data when save post
	 * @param  int $post_id ID of client post
	 * @return void
	 */
	function admin_save_client($post_id){
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
		if( isset($_POST['post_type']) && 'client' == $_POST['post_type'] ){
			if( !empty($_POST['client-url']) ){
				update_post_meta($post_id, '_client_url', $_POST['client-url']);
			}
			if( !empty($_POST['client-logo']) ){
				update_post_meta($post_id, '_client_logo', $_POST['client-logo']);
			}
		}
	}
	add_action('save_post', 'admin_save_client');
}


