<?php
 /*
 Template Name: Proceedings Archive
 Template Post Type: proceeding
 */
 do_action('get_header'); ?>

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
        <?php $custom_logo_id = get_theme_mod('custom_logo');
        $image = wp_get_attachment_image_src($custom_logo_id, 'full');
        $home = get_home_url();
        if (has_nav_menu('primary_navigation')) {
            wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'items_wrap'     => '<ul id="%1$s" class="%2$s"><li><a class="site-logo" href="'.$home.'"><img alt="logo image" src="'.$image[0].'"></a></li> %3$s</ul>',
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
        // get posts
        $tabs = [];
        $the_query = new WP_Query(array(
        'post_type'         => 'proceedings',
        'posts_per_page'    => -1,
          'meta_query'      => array (
            'relation'      => 'AND',
            'session_start' => array (
              'key'         => 'session_date',
              'compare'     => 'EXISTS',
           ),
            'session_num'   => array (
              'key'         => 'session',
              'compare'     => 'EXISTS',
           )
         ),
          'orderby'         => array(
            'session_start'  => 'ASC',
            'session_num'       => 'ASC'
         )
        ));
?>
        <div class="tabs">
          <ul class="schedule">
            <li><a href="#1-19-17">Jan 19th</a></li>
            <li><a href="#2-3-17">Feb 3rd</a></li>
            <li><a href="#2-8-17">Feb 8th</a></li>
            <li><a href="#2-26-17">Feb 26th</a></li>
          </ul>
        <?php
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
                $the_query->the_post();
                $eventdate = date("n-j-y", strtotime(get_field('session_date')));
                $session = get_field('session');
                if (!isset($tabs[$eventdate])) {
                    $tabs[$eventdate] = get_field('session_date');
                }
                if (isset($currentDay) && $currentDay != $eventdate) {
                    echo '</div>';
                }
                if (!isset($currentDay) || $currentDay != $eventdate) {
                    $currentDay = $eventdate;
                    $currentSession = '';
                    echo '<div id="' . $eventdate . '">';
                }
                echo '<article class="session-schedule">';
                if (!isset($currentSession) || $currentSession != $session) {
                    $currentSession = $session;
                    echo '<div class="session">';
                    echo '<div class="title">';
                    //echo ' <h1>' . $session . '</h1> <h2> | ' . get_field('session_date') . ' | Room ' . get_field('room') . '</h2>';
                    if (is_array($session)) {
                         $rooms = get_field('session');
                        foreach ($rooms as $room) {
                            echo $room;
                        }
                    } else {
                          the_field('session');
                    }
                    echo '</div>';
                    echo '</div>';
                }
                echo '<h2 class="title">' . get_the_title() . '</h2>';
                the_title();
                if (function_exists('coauthors_posts_links')) {
                    //coauthors_posts_links();
                    echo 'Authors:' . proceedings_author_shortcode();
                } else {
                    echo 'Authors:' . the_author_posts_link();
                }
                echo '</article>';
            endwhile;
        endif;
        echo var_dump($tabs); ?>
        </div>
     </main>
   </div>
 </div>

<?php
wp_reset_query();
do_action('get_footer'); ?>

 <footer class="content-info">
   <div class="container">
        <?php dynamic_sidebar('sidebar-footer'); ?>
   </div>
 </footer>

<?php wp_footer(); ?>
