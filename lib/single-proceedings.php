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
            <?php if (function_exists( 'the_bylines_posts_links' )) {
              $bylines = get_bylines();
              $authors = [];
              foreach ($bylines as $byline) {
                if ((get_user_by('ID', $byline->ID)) || get_user_by('slug', $byline->slug)) {
                  //
                } else {
                    $authors[] = $byline;
                }
              }
              //echo var_dump($authors);
              if((count($authors) > 0)) {
                echo '<h2>Authors: ';
                $i = 0;
                while ($i < count($authors)) {
                  echo '<a href="'.$authors[$i]->link.'">'.$authors[$i]->display_name.'</a>';
                  if ($i === (count($authors)-2)) {
                    echo ' and ';
                  } else {
                    echo ', ';
                  }
                  $i++;
                }
              }
            }?>
            </h2>
            <?php the_content(); ?>
          </div>

          <div class="entry-info col-4">
            <h3><a href="<?php echo get_permalink($session); ?>"><?php echo get_the_title($session); ?></a></h3>
            <h4 class="brand color">
                <?php echo date("l M j", strtotime(get_field('date', $session))); ?>
                <br />
                Room <?php the_field('room', $session); ?> <br />
                <?php the_field('start_time', $session); ?> - <?php the_field('end_time', $session); ?>
            </h4>
            <?php if (get_field('speaker')) { ?>
            <h5>Speaker: <?php the_field('speaker'); ?></h5>
            <?php }; ?>
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
