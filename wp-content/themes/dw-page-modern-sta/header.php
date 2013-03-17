<?php
/**
 * The Header for our theme.
 *
 * @package DW Page
 * @since DW Page 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php wp_title( '|', true, 'right' )?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(''); ?>/assets/css/template.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(''); ?>/assets/css/template-responsive.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
  /* We add some JavaScript to pages with the comment form
   * to support sites with threaded comments (when in use).
   */
  if ( is_singular() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );

  /* Always have wp_head() just before the closing </head>
   * tag of your theme, or you will break many plugins, which
   * generally use this hook to add elements to <head> such
   * as styles, scripts, and meta tags.
   */
  wp_head();
?>
</head>

<body <?php body_class(); ?> data-spy="scroll" data-offset="61" data-target=".nav-collapse">
    <!-- NAVIGATION -->
    <nav id="nav" class="navbar navbar-fixed-top <?php echo get_option('_dw_page_navbar_class'); ?>">
        <div class="navbar-inner">
            <div class="container">
                <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>

                <a href="<?php echo site_url(); ?>" class="brand"><?php echo html_entity_decode( get_bloginfo('name') ); ?></a>

                <?php dw_page_generate_menu(); ?>
            </div>
        </div>
    </nav>
    <!-- //NAVIGATION -->