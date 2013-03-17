<?php
/**
 * Theme shortcodes functions
 *
 * @package DW Page
 * @since DW Page 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Google Maps
/*-----------------------------------------------------------------------------------*/
add_shortcode("googlemaps", "dw_page_google_maps_shortcode");
function dw_page_google_maps_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		"width" => '640',
		"height" => '480',
		"src" => ''
	), $atts));
	return '<div class="map"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'"></iframe></div>';
}

/*-----------------------------------------------------------------------------------*/
/* Authors List
/*-----------------------------------------------------------------------------------*/
add_shortcode("authors", "dw_page_list_authors_shortcode");
function dw_page_list_authors_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		"number" => '8'
	), $atts));
	$authors = get_users('orderby=registered&oder=DESC&number='.$number);

	$authors_list.= '<div class="members-list row-fluid">';
	$i=0;
	foreach ($authors as $author) {
		if($i%4==0) :
			$class = 'first span3';
		else :
			$class = 'span3';
		endif;

		$authors_list.= '<div class="'.$class.'">';
		if($avatar_link = get_the_author_meta( 'avatar_link', $author->ID )) :
			$authors_list.= '<img src="'.$avatar_link.'" title="'.$author->display_name.' avatar" />';
		else :
			$authors_list.= get_avatar( $author->user_email, 220 );
		endif;
		$authors_list.= '<h3 class="name">'.$author->display_name.'</h3>';
		if($job = get_the_author_meta( 'job', $author->ID )) :
			$authors_list.= '<div class="job">'.$job.'</div>';
		endif;
		if($description = get_the_author_meta( 'description', $author->ID )) :
			$authors_list.= '<div class="description">'.$description.'</div>';
		endif;
		$authors_list.= '<ul class="member-socials">';
		if($facebook = get_the_author_meta( 'facebook', $author->ID )) :
			$authors_list.= '<li class="facebook"><a href="http://facebook.com/'.$facebook.'" title="'.$facebook.'">'.$facebook.'</a></li>';
		endif;
		if($twitter = get_the_author_meta( 'twitter', $author->ID )) :
			$authors_list.= '<li class="twitter"><a href="http://twitter.com/'.$twitter.'" title="'.$twitter.'">'.$twitter.'</a></li>';
		endif;
		if($skype = get_the_author_meta( 'skype', $author->ID )) :
			$authors_list.= '<li class="skype"><a href="skype:'.$skype.'?call" title="'.$skype.'">'.$skype.'</a></li>';
		endif;
		if($vimeo = get_the_author_meta( 'vimeo', $author->ID )) :
			$authors_list.= '<li class="vimeo"><a href="http://vimeo.com/'.$vimeo.'" title="'.$vimeo.'">'.$vimeo.'</a></li>';
		endif;
		if($youtube = get_the_author_meta( 'youtube', $author->ID )) :
			$authors_list.= '<li class="youtube"><a href="http://www.youtube.com/user/'.$youtube.'" title="'.$youtube.'">'.$youtube.'</a></li>';
		endif;
		$authors_list.= '</ul>';
		
		$authors_list.= '</div>';
		$i++;
	}
	$authors_list.= '</div>';
	return $authors_list;
}

// Add extra profile information
add_action( 'personal_options_update', 'dw_page_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'dw_page_save_extra_profile_fields' );
function dw_page_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'job', $_POST['job'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
	update_user_meta( $user_id, 'skype', $_POST['skype'] );
	update_user_meta( $user_id, 'vimeo', $_POST['vimeo'] );
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
	update_user_meta( $user_id, 'avatar_link', $_POST['avatar_link'] );
}

add_action( 'show_user_profile', 'dw_page_extra_profile_fields' );
add_action( 'edit_user_profile', 'dw_page_extra_profile_fields' );
function dw_page_extra_profile_fields( $user ) { ?>
<h3>Extra profile information</h3>
<table class="form-table">
	<tr>
		<th><label for="job">Job Title</label></th>
		<td>
			<input type="text" name="job" id="job" value="<?php echo esc_attr( get_the_author_meta( 'job', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description">Please enter your Job title.</span>
		</td>
	</tr>
	<tr>
		<th><label for="facebook">Facebook</label></th>
		<td>
			<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description">Please enter your Facebook username.</span>
		</td>
	</tr>
	<tr>
		<th><label for="twitter">Twitter</label></th>
		<td>
			<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description">Please enter your Twitter username.</span>
		</td>
	</tr>
	<tr>
		<th><label for="twitter">Flickr</label></th>
		<td>
			<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description">Please enter your Flick username.</span>
		</td>
	</tr>
	<tr>
		<th><label for="avatar_link">Avatar link</label></th>
		<td>
			<input type="text" name="avatar_link" id="avatar_link" value="<?php echo esc_attr( get_the_author_meta( 'avatar_link', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description">Please enter your Avatar image link.</span>
		</td>
	</tr>
</table>
<?php }

/*---------------------------------------------------------------------------*/
/* One Page Shortcode
/*---------------------------------------------------------------------------*/

add_shortcode('onepage', 'dw_page_shortcode_display');
function dw_page_shortcode_display(){
	extract(shortcode_atts(array(
			'type' => 'main',
		), $atts));
?>
<section id="<?php echo $id ?>" class="section <?php echo $classes ?>">
    <div class="container">
        <!-- Section title -->
        <div class="section-title">
            <h1><?php echo $title; ?></h1>
            <?php if( !empty($attr_title) ){ ?>
            <p><?php echo $attr_title;  ?></p>
            <?php } ?>
        </div>

        <div class="section-content row-fluid">
        </div>
    </div>
</section>
<?php
}

/*---------------------------------------------------------------------------*/
/* NEXT SECTION button
/*---------------------------------------------------------------------------*/

if( !function_exists('dw_page_next_section_button') ){
	function dw_page_next_section_button($atts){
		extract(shortcode_atts(array(
				'text'	=> __('next','dw-page')
			), $atts));
		$btn = '<a class="arrow-down img-circle" href="javascript:void(0)">'.$text.'</a>';
		return $btn;
	}
	add_shortcode('onepage_btn_next_section', 'dw_page_next_section_button');
}

/*---------------------------------------------------------------------------*/
/* GO TO SECTION button
/*---------------------------------------------------------------------------*/
if( !function_exists('dw_page_goto_section_button') ){
	function dw_page_goto_section_button($atts){
		extract(shortcode_atts(array(
				'text'	=>	__('View Our Works','dw-page'),
				'sectionID'	=>	'#',
				'class'	=>	'btn-primary btn-large btn-tpl-1'
			), $atts) );
		return '<a class="btn '.$class.'" href="javascript:void(0);" onclick="goToSectionID(\''.$sectionID.'\')">'.$text.'</a>';
	}
	add_shortcode('onepage_btn_goto_section', 'dw_page_goto_section_button');
}

/*---------------------------------------------------------------------------*/
/* Onepage Shortcode for Client PostType
/*---------------------------------------------------------------------------*/
if( !function_exists('dw_page_shortcode_clients') ){
	function dw_page_shortcode_clients($atts){
		extract(shortcode_atts( array(
				'row'	=>	1,
				'col'		=>	6,
				'display'	=>	'random'
			), $atts) );
		$number = $row*$col;
		if( $display == "latest" ){
			$query = '';
		}else{
			$query = '&orderby=rand';
		}
		$the_query = new WP_Query( 'post_type=client&posts_per_page='.$number.$query );
		if($the_query->have_posts()) :
			$span = 'span' . 12 / $col;
		$clients = '<div class="clients"><div class="row-fluid">';
		$clients .= '<ul class="thumbnails">';
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$id = get_the_ID();
			$client_title = get_the_title($id);
			$client_url = get_post_meta($id, '_client_url', true);
			$client_logo = get_post_meta($id, '_client_logo', true);
			$clients .= '<li class="'.$span.' client">
		      <a class="thumbnail" href="'.$client_url.'">
		        <img src="'.$client_logo.'" alt="'.$client_title.'">
		      </a>
		    </li>';
		endwhile;
		$clients .= '</ul></div></div>';

		return $clients;
		endif;
	}
	add_shortcode('onepage_clients', 'dw_page_shortcode_clients');
}
/*-----------------------------------------------------------------------------------*/
/* DW ONEPAGE Testimonials List Shortcode
/*-----------------------------------------------------------------------------------*/
add_shortcode( "onepage_testimonials", "dw_page_list_testimonials_shortcode" );
function dw_page_list_testimonials_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		"row" => '1',
		"col" => '2',
		"display"	=>	"random"
	), $atts));
	$number = $row * $col;
	if( $display == "latest" ){
		$query = '';
	}else{
		$query = '&orderby=rand';
	}
	$the_query = new WP_Query( 'post_type=testimonial&posts_per_page='.$number.$query);

	if($the_query->have_posts()) :
		
		$testimonials = '<div class="testimonials">';
		$span = 12 / $col;
		$span = 'span'.$span;
		$i = 0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			if( $i % $col == 0 ){
				if( $i != 0 ){
					$testimonials .= '</div>';
				}
				$testimonials .= '<div class="row-fluid">';
			}
			$id = get_the_ID();
			$data = get_post_meta($id);
			$avatar 	= !empty($data['_testimonial_avatar'][0]) ? $data['_testimonial_avatar'][0] : '' ;
			$content 	= !empty($data['_testimonial_content'][0]) ? $data['_testimonial_content'][0] : '' ;
			$name 		= !empty($data['_testimonial_name'][0]) ? $data['_testimonial_name'][0] .', ' : '' ;
			$website 	= !empty($data['_testimonial_website'][0]) ? $data['_testimonial_website'][0] : '' ;
			$company 	= !empty($data['_testimonial_company'][0]) ? $data['_testimonial_company'][0] : '' ;
			$job 	= !empty($data['_testimonial_job'][0]) ? $data['_testimonial_job'][0].', ' : '' ;

			$testimonials .= '
		<div class="'.$span.' testimonial thumbnail ">
			<img class="media-object" src="'.$avatar.'" alt="">
			<blockquote>
				  <p>'.$content.'</p>
				  <small>'.$name.$job.' <cite><a href="'.$website.'">'.$company.'</a></cite></small>
			</blockquote>
		</div>';
			$i++;
		endwhile;
		if( ($i - 1 ) % $col != 0 ) $testimonials .= '</div>';
		$testimonials .= '</div>';

		return $testimonials;
	endif;

}


/*---------------------------------------------------------------------------*/
/* Project shortcode
/*---------------------------------------------------------------------------*/
add_shortcode('onepage_projects', 'dw_page_shortcode_projects');
function dw_page_shortcode_projects($atts){
	extract(shortcode_atts( array(
			'number'	=>	-1,
			'col'		=>	4,
			'row'		=>	2,
		), $atts) );
	$size = 'small';
	if( is_mobile() || is_kindle() || is_samsung_galaxy_tab() || is_nexus() ){
		$col = 1; $row = 1;
		$size = 'medium';
	}

	$the_query = new WP_Query( 'post_type=project&posts_per_page='.$number );
	$ppp = $col * $row;
	$carouselID = sha1(microtime(true).mt_rand(10000,90000));
	if( $the_query->have_posts() ){
		$projects = '<div class="portfolio '.implode(' ', get_post_class() ).'">';
		$projects .= '<div class="row-fluid">
  			<div id="carousel-'.$carouselID.'" data-interval="5000" class="carousel slide">';

  		//Carousel inner
  		$projects .= '<div class="carousel-inner">';
	    $i = 0;
	    while( $the_query->have_posts() ): $the_query->the_post();

	    	if( $i % $ppp == 0 ){
	    		if( $i != 0 ){
	    			$projects .= '</ul></div>';
	    		}
			    //Carousel item
			    $projects .='<div class="item';

			    if( $i == 0 )
			    	$projects .= ' active';

			    $projects .= '"><ul class="thumbnails">';
	    	}

	    	
	    	$project_id = get_the_ID();
			$thumbnail = get_post_meta($project_id, '_project_thumbnail_'.$size, true);
			if( !$thumbnail ){
				$thumbnail = get_post_meta($project_id, '_project_thumbnail_small', true);
			}

		    $projects .= '<li class="span3 block">
		      <div class="thumbnail">
		      	<div class="screenshot">
		      		<a href="#modal-'.$carouselID.'" class="show-popup" data-project="'.$project_id.'" ><img src="'.$thumbnail.'" alt="'.get_post_meta($project_id, '_project_skill', true).'"></a>';
		     if( is_mobile() || is_tablet_but_ipad() ){
		     	$projects .= '<div class="carousel-nav">
						<a class="carousel-control left" href="#carousel-'.$carouselID.'" data-slide="prev">&lsaquo;</a>
						<a class="carousel-control right" href="#carousel-'.$carouselID.'" data-slide="next">&rsaquo;</a>
				    </div><!-- Carousel nav -->';
		     }
		      		
		    $projects .= '</div>
		        
		        <div class="caption">
		          <h2 class="section-content-title">
		            <a href="#modal-'.$carouselID.'" class="show-popup" data-project="'.$project_id.'">'.get_the_title().'</a>		            
		          </h2>
		          <p class="meta">'.get_post_meta($project_id, '_project_skill', true).'</p>
		        </div>
		      </div>';

		    if( is_mobile() || is_tablet_but_ipad()  ){
		    	$client = get_post_meta($project_id, '_project_client', true);
                $skill = get_post_meta($project_id, '_project_skill', true);
                $url = get_post_meta($project_id, '_project_url', true);
                $date = get_the_date('M d,Y');

                $detail = array();

                if( $client )
                    $detail[] = '<span class="first"><i class="icon-user"></i><strong>Client:</strong> ' . $client .'</span>';
                if( $date )
                    $detail[] = '<span><i class="icon-calendar"></i><strong>Date:</strong> '.$date .'</span>';  
                if( $skill )
                    $detail[] = '<span class="first"><i class="icon-certificate"></i><strong>Skill:</strong> ' . $skill .'</span>';
                if( $url )
                    $detail[] = '<span><i class="icon-share"></i><a href="'.$url.'">Launch Project</a>' .'</span>';

                $details = implode('', $detail);

		    	$projects .= '<div class="project-details hide"><div class="project-inner">
		    				<p class="project-data">'.$details.'</p>
		    				<p class="project-content">'.get_the_content().'</p>
		    				</div></div>';
		    }

		    $projects .= '</li>';
		    $i++;
	    endwhile;
	    if( ($i - 1) % $ppp != 0 || $col == 1){ $projects .= '</ul></div>'; }


	    $projects .= '</div>';//CLose carousel inner
  		// Carousel Nav
  		$projects .= '<div class="carousel-nav">
			<ul>
			</ul>
	    </div><!-- Carousel nav -->';

  		$projects .= '</div></div></div>';
  		return $projects;
	}
}

/*---------------------------------------------------------------------------*/
/* Team Shortcode for OnePage
/*---------------------------------------------------------------------------*/
if( !function_exists('dw_page_team') ){
	function dw_page_team($atts){
	    extract(shortcode_atts(array(
	            'col' => 4
	        ), $atts));

	    $span = 'span' . (12 / $col);
	    $content = '';
	    $users = get_users();
	    if( !empty($users) ):
	    $team = '<div class="team">';
	    $team .= '<ul class="thumbnails" >';

	    $i = 0;
	    foreach ($users as $user) {
	    	$class = '';
	    	if( $i % $col == 0 ){
	    		$class .= 'first ';
	    	}

	    	if( $i % ($col - 2) == 0 && $i != 0 )
	    		$class .= 'third';

	    	if( $i % ($col - 1) == 0  && $i != 0 )
	    		$class .= 'end';
	        $user_facebook = get_user_meta($user->ID, 'facebook', true);

	        $user_twitter = get_user_meta($user->ID, 'twitter', true);

	        $user_flickr = get_user_meta($user->ID, 'flickr', true);


	        $team .= '<li class="'.$span.' personal '.$class.'">
	        <div class="thumbnail">';
	        $avatar = get_the_author_meta('avatar_link', $user->ID);
	        $avatar = !empty($avatar) ? $avatar : DW_PAGE_URI.'assets/img/team-1.jpg';
	        $team .= '<a href="#"><img src="'.$avatar.'" alt=""></a>';
	        $team .='<div class="caption">
	                <h3 class="section-content-title">'.$user->display_name.'</h3>
	                
	                <p class="meta">'.get_the_author_meta('job', $user->ID).'</p>

	                <p>'.get_user_meta($user->ID, 'description', true).'</p>

	                <ul class="social social-inline">';
	        if( $user_facebook ){
	            $team .= '<li><a href="https://facebook.com/'.$user_facebook.'">
	            	<i class="icon-facebook-2"></i></a></li>';
	        }

	        if( $user_twitter ){
	            $team .= '<li><a href="https://twitter.com/'.$user_twitter.'"><i class="icon-twitter-2"></i></a></li>';
	        }

	        if( $user_flickr ){
	            $team .= '<li><a href="http://www.flickr.com/photos/'.$user_flickr.'/"><i class="icon-flickr-2"></i></a></li>';
	        }
	                  
	                  
	        $team .= '</ul>
	              </div>
	            </div>
	        </li>';

	        $i++;
	    } 

	    //Hiring
	    if( get_option('dw_page-hire-enable') == 'enable' ){
	    	$class = '';
	    	if( $i % $col == 0 ){
	    		$class .= 'first ';
	    	}

	    	if( $i % ($col - 2) == 0 && $i != 0 )
	    		$class .= 'third';

	    	if( $i % ($col - 1) == 0  && $i != 0 )
	    		$class .= 'end';
	        $team .= '<li class="span3 personal hiring '.$class.'">
	            <div class="thumbnail">
	              <a href="javascript:void(0);" onclick="goToSectionID(\'#'.get_option('dw_page-hire-contact').'\')"><img src="'.get_stylesheet_directory_uri().'/assets/img/hiring.png" alt=""></a>
	              <div class="caption">
	                <h3 class="section-content-title">
	                    <a href="javascript:void(0);" onclick="goToSectionID(\'#'.get_option('dw_page-hire-contact').'\')">'.get_option('dw_page-hire-title',__('We are hiring','dw-page') ).'</a>
	                </h3>
	                <p class="meta">'.get_option('dw_page-hire-job', __('Team member','dw-page') ).'</p>

	                <p>'.get_option('dw_page-hire-desc', '').'</p>
	              </div>
	            </div>
	          </li>';
	        $i++;
	    }

	    $team .= '</ul></div>';
	    return $team;
	    endif;
	}
	add_shortcode('onepage_ourteam', 'dw_page_team');
}

/*---------------------------------------------------------------------------*/
/* TinyMCE custom for shortcode
/*---------------------------------------------------------------------------*/
function dw_page_addbuttons() {
	global $pagenow;

   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 	if( $pagenow == 'post.php' && isset($_GET['post']) && 'page' == get_post_type($_GET['post']) ){
 		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", "dw_page_editor_add_tinymce_plugin");
			add_filter('mce_buttons', 'dw_page_editor_register_button');
		}
 	}
}
 
function dw_page_editor_register_button($buttons) {
   array_push($buttons, 'dw_page_projects', 'dw_page_testimonial','dw_page_client', 'dw_page_team' ); 
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function dw_page_editor_add_tinymce_plugin($plugin_array) {
   $plugin_array['dw_page_projects'] = DW_PAGE_URI .'assets/admin/js/dw-page-project-shortcode.js';
   $plugin_array['dw_page_testimonial'] = DW_PAGE_URI .'assets/admin/js/dw-page-testimonial-shortcode.js';
   $plugin_array['dw_page_client'] = DW_PAGE_URI .'assets/admin/js/dw-page-client-shortcode.js';
   $plugin_array['dw_page_team'] = DW_PAGE_URI .'assets/admin/js/dw-page-team-shortcode.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'dw_page_addbuttons');
?>