<?php
 /*
 Template Name: Single Proceeding
 Template Post Type: proceeding
 */

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
            <h2>Authors: <?php
            if (function_exists('coauthors_posts_links')) {
                //coauthors_posts_links();
                echo Proceedings\Filters\proceedings_author_shortcode();
            } else {
                echo the_author_posts_link();
            } ?>
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
            <?php if (get_field('proceeding-file')) {
                $file = get_field('proceeding_file');?>
                <h6><a href="<?php echo $file['url']; ?>">Download Proceeding <i class="fa fa-download" aria-hidden="true"></i></a></h6>
            <?php }; ?>
          </div>
        </div>

        <footer>
          <nav class="post-nav row">
            <div class="previous col"><?php previous_post_link('%link', '<i class="fa fa-arrow-left" aria-hidden="true"></i> Previous'); ?></div>
            <div class="next col"><?php next_post_link('%link', 'Next <i class="fa fa-arrow-right" aria-hidden="true"></i>'); ?></div>
          </nav>
        </footer>
       </article>
        <?php endwhile; ?>
