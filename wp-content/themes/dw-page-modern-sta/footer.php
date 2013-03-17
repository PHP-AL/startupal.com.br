<?php
/**
 * The Footer for our theme.
 *
 * @package DW Page
 * @since DW Page 1.0
 */
?>
    <footer id="colophon" class="<?php echo get_option('_dw_page_footer_class') ?>">
        <div class="container">
            <div class="copyright">
                <div class="site-info">
                    Copyright &copy; 2012 by <a href="<?php echo site_url() ?>" title="<?php bloginfo('description') ?>"><?php echo preg_replace('/\&lt;[^(\&gt;)]*(&gt;)/i','',get_bloginfo( 'name' ) ) ; ?></a>. Powered by <a href="http://wordpress.org">WordPress</a>. <br>
                    <?php bloginfo('description'); ?>
                </div>
            </div>

            <ul class="social social-inline">
                <?php $facebook = get_option('dw_page-facebook');
                    if( $facebook ){ ?>
                <li><a href="<?php echo $facebook ?>"><i class="icon-facebook-3"></i></a></li> <?php } ?>

                <?php $twitter = get_option('dw_page-twitter');
                    if( $twitter ){
                ?>
                <li><a href="<?php echo $twitter ?>"><i class="icon-twitter-3"></i></a></li><?php } ?>
                
                <?php $flickr = get_option('dw_page-flickr');
                    if( $flickr ){ ?>
                <li><a href="<?php echo $flickr ?>"><i class="icon-flickr-3"></i></a></li> <?php } ?>
            </ul>
        </div>
    </footer>
<?php wp_footer(); ?>
</body>
</html> 