<?php
 /*
 Template Name: Single Session
 Template Post Type: session
 */

if (have_posts()) :
    while (have_posts()) :
        the_post();
        $date = date("F j", strtotime(get_field('date')));
        $time = $date . ' ' . get_field('start_time');
        $time = date('Y-m-d H:i:s', strtotime($time));
        $session = get_the_ID();
        $session_title = get_the_title();
        ?>
          <header class="session-header">
           <h1> <?php the_title(); ?>
             <br />
           <small class="accent color"><?php echo $date;
            if (get_field('start_time')) {
                echo ', ' . date("g:i A", strtotime(get_field('start_time')));
            }
            if (get_field('end_time')) {
                echo ' - ' . date("g:i A", strtotime(get_field('end_time')));
            }
            if (get_field('room')) {
                echo ' | Room ' . get_field('room');
            }
            ?></small></h1>
         </header>
        <?php
    endwhile;
    wp_reset_postdata();
endif;

$the_query = new WP_Query(array(
'post_type'         => ['proceedings', 'speaker'],
'meta_query'        => [
    'relation' => 'OR',
    [
      'key'   => 'session',
      'value' => $session,
    ],
    [
      'relation' => 'AND',
      [
        'key'   => 'session_title',
        'value' => $session_title,
      ],
      [
        'key'   => 'session',
        'value' => $time,
      ]
    ]
  ]
));

if ($the_query->have_posts()) :
    echo '<section class="session-archive">
    <h2>During this Session:</h2>';
    while ($the_query->have_posts()) :
        $the_query->the_post();
        echo '<h3><a class="accent color" href="' . get_the_permalink() . '">';
        the_title();
        echo '</a></h3>';
        //echo '<p><span style="font-weight: bold;">Authors: </span> ' . $author . '</p>';
    endwhile;
    echo '</section>';
    wp_reset_postdata();
endif;
