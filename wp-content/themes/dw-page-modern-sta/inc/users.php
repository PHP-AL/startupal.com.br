<?php
/**
 * User functions and definitions
 *
 * @package DW Page
 * @since DW Page 1.0
 */

/*---------------------------------------------------------------------------*/
/* USER Our team Insert avatar
/*---------------------------------------------------------------------------*/
if( !function_exists('dw_page_get_avatar') ){
    function dw_page_get_avatar($avatar, $id_or_email, $size, $default, $alt){
        //Get user email from get_avatar filter
        if( is_object($id_or_email) ){
            $user_id = $id_or_email->user_id;
        }else if( is_email($id_or_email) ){
            $user = get_user_by('email',$id_or_email);
            $user_id = $user->ID;
        }else if( is_numeric($id_or_email) ){
            $user_id = $id_or_email;
        }
        // If is user registered get avatar
        if( isset($user_id) && $user_id > 0 ){
            if( $avatar_link = get_the_author_meta( 'avatar_link', $user_id) ) {
                $safe_alt = esc_attr($alt);
                $avatar = "<img alt='{$safe_alt}' src='{$avatar_link}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
                
            }
        }
        return $avatar;
    }
    add_filter('get_avatar', 'dw_page_get_avatar',10,5);
}


/*---------------------------------------------------------------------------*/
/* HIRE SETTING PAGE: On HIRE new team member
/*---------------------------------------------------------------------------*/

if( !function_exists('dw_page_hiring_setting_menu') ){
    add_action('admin_menu', 'dw_page_hiring_setting_menu');
    //Add submenu page 
    function dw_page_hiring_setting_menu(){
        add_users_page(__('Setting on Hire','dw-page'), __('Hire', 'dw-page'), 'manage_options', 'dw-page-hire-seting', 'dw_page_hiring_setting');
    }
}

if( !function_exists('dw_page_hiring_setting') ){
    //callback function for menu dw-page-hire-seting
    function dw_page_hiring_setting(){
?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php _e('Hire Alert','dw-page'); ?></h2>
        <form method="post" action="options.php"> 

        <?php settings_fields( 'dw-page-hire-settings' ); ?>
        <table class="form-table">
            <?php do_settings_fields('dw-page-hire-seting', 'dw_page_setting_section_hiring'); ?>
        </table>
        <?php submit_button( __('Update','dw-page') ); ?>
        </form>
    </div>
<?php
    }
}

/*---------------------------------------------------------------------------*/
/* REGISTER SETTING FIELD FOR HIRING SETTING
/*---------------------------------------------------------------------------*/

if( !function_exists('dw_page_hire_register_setting') ){
    add_action('admin_init', 'dw_page_hire_register_setting');

    function dw_page_hire_register_setting(){
        register_setting('dw-page-hire-settings', 'dw_page-hire-enable');
        register_setting('dw-page-hire-settings', 'dw_page-hire-title');
        register_setting('dw-page-hire-settings', 'dw_page-hire-job');
        register_setting('dw-page-hire-settings', 'dw_page-hire-desc');
        register_setting('dw-page-hire-settings', 'dw_page-hire-contact');

        add_settings_section('dw_page_setting_section_hiring', __('Hire Section Settings','dw-page'), 'dw_page_setting_section_hiring_callback', 'dw-page-hire-seting');


        add_settings_field('dw_page-hire-enable', __('Status','dw-page'), 'dw_page_hire_setting_field_enable', 'dw-page-hire-seting', 'dw_page_setting_section_hiring');
        add_settings_field('dw_page-hire-title', __('Title','dw-page'), 'dw_page_hire_setting_field_title', 'dw-page-hire-seting', 'dw_page_setting_section_hiring');
        add_settings_field('dw_page-hire-job', __('Job','dw-page'), 'dw_page_hire_setting_field_job', 'dw-page-hire-seting', 'dw_page_setting_section_hiring');
        add_settings_field('dw_page-hire-desc', __('Description','dw-page'), 'dw_page_hire_setting_field_desc', 'dw-page-hire-seting', 'dw_page_setting_section_hiring');
        add_settings_field('dw_page-hire-contact', __('Contact Section','dw-page'), 'dw_page_hire_setting_field_contact', 'dw-page-hire-seting', 'dw_page_setting_section_hiring');
    }

    function dw_page_setting_section_hiring_callback(){}
}


if( !function_exists('dw_page_hire_setting_field_enable') ){
    function dw_page_hire_setting_field_enable(){
?>
<label for="dw_page-hire-enable">
<input type="checkbox" name="dw_page-hire-enable" id="dw_page-hire-enable" value="enable" <?php checked('enable',get_option('dw_page-hire-enable') ) ?> placeholder="We are hiring"> <?php _e('Turn on hiring','dw-page') ?></label>
<?php
    } 
}


if( !function_exists('dw_page_hire_setting_field_title') ){
    function dw_page_hire_setting_field_title(){
?>
<input <?php disabled(false,get_option('dw_page-hire-enable') ) ?> type="text" name="dw_page-hire-title" id="dw_page-hire-title" value="<?php echo form_option('dw_page-hire-title'); ?>" class="regular-text ltr" placeholder="We are hiring">
<?php
    } 
}

if( !function_exists('dw_page_hire_setting_field_job') ){
    function dw_page_hire_setting_field_job(){
?>
<input <?php disabled(false,get_option('dw_page-hire-enable') ) ?> type="text" name="dw_page-hire-job" id="dw_page-hire-job" value="<?php echo form_option('dw_page-hire-job'); ?>" class="regular-text ltr" placeholder="">
<?php
    }  
}

if( !function_exists('dw_page_hire_setting_field_desc') ){
    function dw_page_hire_setting_field_desc(){
?>
<textarea <?php disabled(false,get_option('dw_page-hire-enable') ) ?> name="dw_page-hire-desc" id="dw_page-hire-desc" class="large-text ltr" rows="10"><?php echo form_option('dw_page-hire-desc'); ?></textarea>
<?php
    }   
}

if( !function_exists('dw_page_hire_setting_field_contact') ){
    function dw_page_hire_setting_field_contact(){
?>
<select <?php disabled(false,get_option('dw_page-hire-enable') ) ?> name="dw_page-hire-contact" id="dw_page-hire-contact" class="regular-text">
<?php
$menu = dw_page_get_menu_items();
    if( $menu ){
        foreach ($menu as $menu_item) {
        $menu_id = sanitize_title($menu_item->title);
?>
    <option value="<?php echo $menu_id ?>" <?php selected(get_option('dw_page-hire-contact'), $menu_id) ?> >
    <?php echo $menu_item->title  ?>
    </option>
<?php
        }    
    }
?>
</select>
<p class="description"><?php _e('Choose the menu section that show contact form, in there guest can contact you for apply hiring','dw-page') ?></p>  
<?php
    }   
}

/*---------------------------------------------------------------------------*/
/* END REGISTER SETTING
/*---------------------------------------------------------------------------*/

?>