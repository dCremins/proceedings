<?php
 /*
 Template Name: Single Proceeding
 Template Post Type: proceeding
 */
 do_action('get_header');
 ?>

 <head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://use.typekit.net/ius0wyf.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>
  <?php wp_head(); ?>
</head>

 <header class="banner">
   <div class="sticky-nav">
     <nav class="container">
       <?php $custom_logo_id = get_theme_mod( 'custom_logo' );
       $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
       $home = get_home_url();
       if (has_nav_menu('primary_navigation')) {
         wp_nav_menu([
           'theme_location' => 'primary_navigation',
           'items_wrap'     => '<ul id="%1$s" class="%2$s"><li><a class="site-logo" href="'.$home.'"><img src="'.$image[0].'"></a></li> %3$s</ul>',
           'container'      => false,
           'menu_class'     => 'nav']);
       } ?>
     </nav>
   </div>
 </header>

 <div class="wrap container" role="document">
   <div class="content">
     <main class="main">

       <?php
       $mypost = array( 'post_type' => 'proceedings', );
       //$loop = new WP_Query( $mypost );
       //while ( $loop->have_posts() ) : $loop->the_post();
       while ( have_posts() ) : the_post();
       ?>
       <article <?php post_class(); ?>>
         <header>
          <h1 class="entry-title"> <?php the_title(); ?></h1>
        </header>
        <div class="row">
          <div class="entry-content col-8">
            <h2>Authors: <?php
              if ( function_exists( 'coauthors_posts_links' ) ) {
                  //coauthors_posts_links();
                  proceedings_author_shortcode();
              } else {
                  the_author_posts_link();
              } ?>
            </h2>
            <?php the_content(); ?>
          </div>
          <div class="entry-info col-4">
            <h3>Session <?php the_field('session'); ?></h3>
            <h4><?php the_field('date'); ?><br />
              Room <?php the_field('room'); ?> | <?php the_field('date'); ?></h4>
            <h5>Speaker: <?php the_field('speaker'); ?></h5>
            <?php $file = get_field('proceeding_file');?>
            <h6><a href="<?php echo $file['url']; ?>">Download Proceeding <i class="fa fa-download" aria-hidden="true"></i></a></h6>
          </div>
        </div>
        <footer>
          <nav class="post-nav row">
            <div class="previous col"><?php previous_post_link( '%link', '<i class="fa fa-arrow-left" aria-hidden="true"></i> Previous' ); ?></div>
            <div class="next col"><?php next_post_link( '%link', 'Next <i class="fa fa-arrow-right" aria-hidden="true"></i>' ); ?></div>
          </nav>
        </footer>
       </article>
     <?php endwhile; ?>
     </main>
   </div>
 </div>

 <?php wp_reset_query();
 do_action('get_footer'); ?>

 <footer class="content-info">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
  </div>
</footer>
<?php wp_footer(); ?>
