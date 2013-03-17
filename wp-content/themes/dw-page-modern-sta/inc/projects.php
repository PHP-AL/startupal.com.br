<?php
/**
 * Projects functions and definitions
 *
 * @package DW Page
 * @since DW Page 1.0
 */

/*-----------------------------------------------------------------------------------*/
/*	Register Project post format.
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'project_posttype_init' );
if ( !function_exists( 'project_posttype_init' ) ) :
function project_posttype_init() {

	$project_labels = array(
		'name' => _x('Projects', 'post type general name','dw-page'),
		'singular_name' => _x('Project', 'post type singular name','dw-page'),
		'add_new' => _x('Add New', 'project','dw-page'),
		'add_new_item' => __('Add New Project','dw-page'),
		'edit_item' => __('Edit Project','dw-page'),
		'new_item' => __('New Project','dw-page'),
		'all_items' => __('All Projects','dw-page'),
		'view_item' => __('View Project','dw-page'),
		'search_items' => __('Search Projects','dw-page'),
		'not_found' =>  __('No projects found','dw-page'),
		'not_found_in_trash' => __('No projects found in Trash','dw-page'), 
		'parent_item_colon' => '',
		'menu_name' => __('Projects','dw-page')

	);
	$project_args = array(
		'labels' => $project_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => get_template_directory_uri().'/assets/img/posttype-project.png',
		'supports' => array( 'title', 'editor' )
	); 
	register_post_type( 'project', $project_args );

}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Project custom taxonomies.
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'project_taxonomies_innit', 0 );
if ( !function_exists( 'project_taxonomies_innit' ) ) :
function project_taxonomies_innit() {
	// Project Category
	$labels = array(
		'name' => _x( 'Categories', 'taxonomy general name','dw-page'),
		'singular_name' => _x( 'Category', 'taxonomy singular name','dw-page' ),
		'search_items' =>  __( 'Search Categories','dw-page' ),
		'all_items' => __( 'All Categories','dw-page'),
		'parent_item' => __( 'Parent Category','dw-page'),
		'parent_item_colon' => __( 'Parent Category:','dw-page'),
		'edit_item' => __( 'Edit Category','dw-page'), 
		'update_item' => __( 'Update Category','dw-page'),
		'add_new_item' => __( 'Add New Category','dw-page'),
		'new_item_name' => __( 'New Category Name','dw-page'),
		'menu_name' => __( 'Category','dw-page'),
	); 	

	register_taxonomy('project-category',array('project'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'project-category' ),
	));

	// Project Tags
	$labels = array(
		'name' => _x( 'Tags', 'taxonomy general name','dw-page'),
		'singular_name' => _x( 'Tag', 'taxonomy singular name','dw-page'),
		'search_items' =>  __( 'Search Tags','dw-page'),
		'popular_items' => __( 'Popular Tags','dw-page'),
		'all_items' => __( 'All Tags','dw-page'),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Tag','dw-page'), 
		'update_item' => __( 'Update Tag','dw-page'),
		'add_new_item' => __( 'Add New Tag','dw-page'),
		'new_item_name' => __( 'New Tag Name','dw-page'),
		'separate_items_with_commas' => __( 'Separate tags with commas','dw-page'),
		'add_or_remove_items' => __( 'Add or remove tags','dw-page'),
		'choose_from_most_used' => __( 'Choose from the most used tags','dw-page'),
		'menu_name' => __( 'Tags','dw-page'),
	); 

	register_taxonomy('project-tag','project',array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'project-tag' ),
	));
}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Add Project Metaboxes
/*-----------------------------------------------------------------------------------*/
// Add metabox
add_action('admin_init', 'project_metabox');
function project_metabox(){
	add_meta_box('project-metabox', 'Project Data', 'project_metabox_callback', 'project', 'normal');
}

// Metabox callback
function project_metabox_callback() { ?>
	<input type="hidden" name="dw_page_post_id" id="dw_page_post_id" value="<?php echo get_the_ID(); ?>" />
	<table width="100%">
		<tr>
			<th class="left"><?php _e('Project URL','dw-page');  ?></th>
			<td>
				<p><input type="text" name="project-url" id="project-url" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_url', true); ?>" ></p>
			</td>
		</tr>
		<tr class="alternate">
			<th class="left"><?php _e('Client Name','dw-page');  ?></th>
			<td>
				<p><input type="text" name="project-client" id="project-client" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_client', true); ?>" ></p>
			</td>
		</tr>
		<tr>
			<th class="left"><?php _e('Project Date','dw-page');  ?></th>
			<td>
				<p><input type="text" name="project-date" id="project-date" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_date', true); ?>" ></p>
			</td>
		</tr>
		<tr class="alternate">
			<th class="left"><?php _e('Project Skills','dw-page');  ?></th>
			<td>
				<p><input type="text" name="project-skill" id="project-skill" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_skill', true); ?>" ></p>
			</td>
		</tr>			
		<tr>
			<th class="left"><?php _e('Project Images','dw-page') ?></th>
			<td>
				<p>
					<input type="text" id="project-thumbnail-small" name="project-thumbnail-small" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_thumbnail_small', true); ?>" />
					<button onclick="return false" class="dw_page_upload_btn button" rel="#project-thumbnail-small" ><?php _e('Upload image','dw-page'); ?></button><br />
					<span class="hint"><?php _e('Small size - Recommend width: 210px', 'dw-page'); ?></span>
				</p>
				<p>
					<input type="text" id="project-thumbnail-medium" name="project-thumbnail-medium" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_thumbnail_medium', true); ?>" />
					<button onclick="return false" class="dw_page_upload_btn button" rel="#project-thumbnail-medium" ><?php _e('Upload image','dw-page'); ?></button><br />
					<span class="hint"><?php _e('Medium size - Recommend width: 290px', 'dw-page'); ?></span>
				</p>
				<p>
					<input type="text" id="project-thumbnail-large" name="project-thumbnail-large" class="regular-text" value="<?php echo get_post_meta(get_the_ID(), '_project_thumbnail_large', true); ?>" />
					<button onclick="return false" class="dw_page_upload_btn button" rel="#project-thumbnail-large" ><?php _e('Upload image', 'dw-page'); ?></button><br />
					<span class="hint"><?php _e('Large size - Recommend width: 400px', 'dw-page'); ?></span>
				</p>
			</td>
		</tr>

	</table>
<?php }


// Action when save post
add_action('save_post', 'admin_save_project');
function admin_save_project($post_id){
	if( !empty($_POST['project-url']) ){
		update_post_meta($post_id, '_project_url', $_POST['project-url']);
	}
	if( !empty($_POST['project-date']) ){
		update_post_meta($post_id, '_project_date', $_POST['project-date']);
	}
	if( !empty($_POST['project-skill']) ){
		update_post_meta($post_id, '_project_skill', $_POST['project-skill']);
	}
	if( !empty($_POST['project-client']) ){
		update_post_meta($post_id, '_project_client', $_POST['project-client']);
	}
	if( !empty($_POST['project-thumbnail-small']) ){
		update_post_meta($post_id, '_project_thumbnail_small', $_POST['project-thumbnail-small']);
	}
	if( !empty($_POST['project-thumbnail-medium']) ){
		update_post_meta($post_id, '_project_thumbnail_medium', $_POST['project-thumbnail-medium']);
	}
	if( !empty($_POST['project-thumbnail-large']) ){
		update_post_meta($post_id, '_project_thumbnail_large', $_POST['project-thumbnail-large']);
	}
	
}

// Actions meta box
function project_metabox_actions(){
	$result = new stdClass();
	
	if( empty($_POST['post_id']) || empty($_POST['image_url']) ){
		$result->status = 'error';
	} else {
		$slide_images = get_post_meta($_POST['post_id'], '_dw_page_slide_images', true);

		foreach ($slide_images as $key => $value) {
				if( $value == $_POST['image_url'] ){
					unset($slide_images[$key]);
					$result->status = 'success';
				}
			}
		update_post_meta($_POST['post_id'], '_dw_page_slide_images', $slide_images);	
	}
	echo json_encode($result);
	exit(0);
		
}
add_action('wp_ajax_dw_page_remove_slide_image', 'project_metabox_actions');
