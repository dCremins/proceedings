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

        <?php

        //echo date("M jS", strtotime(current_time( 'mysql' )));

        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
                $the_query->the_post();
                $eventdate = date("n-j-y", strtotime(get_field('session_date')));
                $session = get_field('session');

                // If the date is not in the tabs array, add it
                /*
                if (!isset($tabs[$eventdate])) {
                    $tabs[] = date("M jS", strtotime(get_field('session_date')));
                }
                */

                // If the date is not in the tabs array, add it
                if (!isset($currentDay) || $currentDay != $eventdate) {
                    $currentDay = $eventdate;
                }

                // If the date is not in the tabs array, add it
                if (!isset($currentSession) || $currentSession != $session) {
                    $currentSession = $session;
                }

                $tabs[$currentDay][$currentSession][] = [
                  'title' => get_the_title(),
                  'session' => get_field('session'),
                  'speaker' => get_field('speaker'),
                  'date' => get_field('session_date'),
                  'room' => get_field('room')[0],
                  'file' => get_field('proceeding_file'),
                  'author' => get_the_title(),
                  'abstract' => get_the_content()
                ];


                /*
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

                */
            endwhile;
        endif;

        // Set up Day Tabs
        echo '<div class="tabs"><ul class="schedule">';
        foreach ($tabs as $day => $session) {
            $t = date_create_from_format("n-j-y", $day);
            echo '<li><a href="#' . date_format($t, "n-j-y") . '">' . date_format($t, "M jS") . '</a></li>';
        }
        echo '</ul>';

        // Set up day blocks
        foreach ($tabs as $day => $session) {
            $t = date_create_from_format("n-j-y", $day);
            echo '<div id="' . date_format($t, "n-j-y") . '">';
            // Set up session headers
            foreach ($session as $sess => $num) {
                echo '<div class="title"><h1>' . $sess . ' | ' . $num[0]['room'] . '</h1></div>';
                // display post information
                foreach ($num as $post) {
                    echo '<h2>' . $post['title'] . ' | ' . $post['room'] . '</h2>';
                    echo '<p>' . $post['author'] . '</p>';
                }
            }
            echo '</div>';
        }

        echo '</div>';?>
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
