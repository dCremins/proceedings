<?php
 /*
 Template Name: Single Proceeding
 Template Post Type: proceeding
 */

 $args = ['post_type' => 'proceedings'];
 $curr_id = $post->ID;
 unset($args['paged']);
 $args['posts_per_page'] = -1;
 $tempposts = [];
 $the_query = new WP_Query($args);
 $post_ids = [];

 if ($the_query->have_posts()) :
     while ($the_query->have_posts()) :
         $the_query->the_post();
         $session = get_field('session');
         $date = get_field('date', $session);
         $eventdate = strtotime($date);
         $start = strtotime(get_field('start_time', $session));
         $tempposts[]=[
           'id' => $post->ID,
           'date' => $eventdate,
           'start' => $start
         ];
     endwhile;
     wp_reset_query();
 endif;

foreach ($tempposts as $temp => $field) {
  $NEWdate[$temp] = $field['date'];
  $NEWstart[$temp] = $field['start'];
}
array_multisort($NEWdate, SORT_ASC, $NEWstart, SORT_ASC, $tempposts);

foreach ($tempposts as $temp => $field) {
  $post_ids[] = $field['id'];
}

 $current_index = array_search($curr_id, $post_ids);
 // Find the index of the next/prev items
 $prev = $current_index - 1;
 $next = $current_index + 1;

while (have_posts()) :
            the_post();
            $session = get_field('session');



        ?>
       <article <?php post_class(); ?>>
         <header>
          <h1 class="entry-title accent color"> <?php the_title(); ?></h1>
        </header>
        <div class="row">
          <div class="entry-content col-8">
            <?php if (function_exists( 'ICO\Bylines\get_the_bylines_posts_link' )) {
                echo '<h2>'.ICO\Bylines\get_the_bylines_posts_link().'</h2>';
            } else {
                $authors = '';
            }?>
            </h2>
            <?php the_content(); ?>
            <?php if (have_rows('proceedings')) {
              echo '<h6><br  />';
              while (have_rows('proceedings')) : the_row();
              $file = get_sub_field('file');
                echo '<a href="'
                . $file['url']
                . '">Download '
                . get_sub_field('type')
                . ' <i class="fa fa-download accent color" aria-hidden="true"></i></a><br  />';
               endwhile;
               echo '</h6>';
            }; ?>
          </div>

          <div class="entry-info col-4">
            <h3><?php echo get_the_title($session); ?></h3>
            <h4 class="brand color">
                <?php echo date("l M j", strtotime(get_field('date', $session))); ?>
                <br />
                Room <?php the_field('room', $session); ?> <br />
                <?php echo date("g:i A", strtotime(get_field('start_time', $session))); ?> - <?php echo date("g:i A", strtotime(get_field('end_time', $session))) ?>
            </h4>
            <?php if (get_field('speaker')) { ?>
            <h5>Speakers: <?php the_field('speaker'); ?></h5>
            <?php }; ?>
          </div>
        </div>

        <footer>
          <nav class="post-nav row">
            <?php if ($prev !== -1) {
              echo '<div class="previous col"><a href="'
              .get_the_permalink($post_ids[$prev])
              .'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</a></div>';
            } ?>
            <?php if ($next !== (count($post_ids)+1)) {
              echo '<div class="next col"><a href="'
              .get_the_permalink($post_ids[$next])
              .'">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>';
            } ?>
          </nav>
        </footer>
       </article>
        <?php endwhile; ?>
