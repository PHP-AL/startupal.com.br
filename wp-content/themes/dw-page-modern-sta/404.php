<?php
/**
 * 404 Page
 *
 * @package DW Page
 * @since DW Page 1.0
 */

do_action('page_404_init');
get_header(); ?>
 <div id="main">
  <header id="page404" class="section header style-1">
    <div class="container ">
      <h1>404</h1>
      <h2>Opps! Something went wrong...</h2>
      <span>Page not found. Please continue to our <a href="<?php echo get_bloginfo('siteurl');  ?>">home page</a></span>
    </div>
  </header>
 </div>
 
 <?php get_footer(); ?>

